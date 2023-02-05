<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <label for="">{{ trans2 }}</label>
                <div class="form-group d-flex me-2">

                    <select   v-model="city.CitySenderRef" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option disabled value="null">Выберите Город</option>
                        <option   :value="'e718a680-4b33-11e4-ab6d-005056801329'" >
                            {{ 'Київ' }}
                        </option>
                        <option   :value="'e71abb60-4b33-11e4-ab6d-005056801329'" >
                            {{ 'Львів' }}
                        </option>
                    </select>
                </div>
                <label for="">{{ trans3 }}</label>
                <div class="form-group d-flex me-2">

                    <select  v-model="selectedCity" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" @change.prevent="getPost()" >
                        <option disabled value="null">Выберите Город</option>
                        <option v-for="(city,i) in cities" :key="city.id"  :value="city" >
                            {{ city.lang.title }}
                        </option>
                    </select>

                </div>
                <template v-if="posts != 0">
                <label for="">{{ trans7  }}</label>
                <div class="form-group d-flex me-2" >
                    <select   v-model="selectedPost" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" >
                        <option disabled value="null">Виберіть відділення</option>
                        <option v-for="(post,i) in posts" :key="post.id"  :value="post" >
                            {{ post.lang.title }}
                        </option>
                    </select>

                </div>
                </template>
                <div class="form-group">
                    <label>{{ trans8 }}</label>
                    <input type="number" v-model.trim="price" class="form-control">
                </div>
                <!--   <span  v-for="(city,i) in cities" :key="i">
                       {{ city.lang.title}}
                   </span>
                   :disabled="!formReady"-->
                <button class="btn btn-success mt-4" :disabled="!city.CitySenderRef || !selectedCity.id || !price" @click.prevent="getCost">
                    {{ trans5 }}</button>
                <!-- <cart-component></cart-component>-->
                <div class="form-group d-flex me-2" v-if="alertCost !== null">
                    <ul>
                        <li> {{ trans6 }} - {{selectedCity.lang.title}} </li>
                         <li> {{ trans7 }} - {{selectedPost.lang.title}} </li>
                        <li> {{ trans4 }} {{ alertCost }} грн. </li>
                    </ul>


                </div>



            </div>

        </div>
    </div>
</template>

<script>
    /*   import CartComponent from "./CartComponent.vue";*/
    import axios from 'axios';
    export default {
        name: "CostDeliveryComponent",
        props: {
            cities: {type: Array},
            trans1: String,
            trans2: String,
            trans3: String,
            trans4: String,
            trans5: String,
            trans6: String,
            trans7: String,
            trans8: String,
        },
        components: {
            /*TestComponent: TestComponent,*/
            /*  CartComponent*/
        },
        data(){
            return {
                selected: '',
                value: '',
                city: {
                    cityId: '',
                    CitySenderRef: '',
                    CityRecipientRef: ''

                },
                selectedCity: {},
                selectedPost: {},
                selectedPostId: '',
                posts: [],
                price: '',
                cost: '',


                //user: {}
            }
        },
        methods: {
            getPost(){
                let cityId =  this.selectedCity.id
                this.cost = null
                axios.get('/posts/' + cityId ).then(response => {

                    if(response.data){

                        this.posts = response.data

                    }

                }).catch((error)=> {
                    // ловим ошибки
                    console.log('sendComment 777', error.response.data.errors)
                    if(error.response.data.errors){
                        /* context.commit('MUTATE_SET_ERRORS_MESSAGE', error.response.data.errors)*/
                    }
                })
            },

            getCost(){

                let CitySenderRef =  this.city.CitySenderRef
                let CityRecipientRef =  this.selectedCity.ref
                let cost = this.price


                axios.post('https://api.novaposhta.ua/v2.0/json/',
                    {
                        "apiKey": "",
                        "modelName": "InternetDocument",
                        "calledMethod": "getDocumentPrice",
                        "methodProperties": {
                            "CitySender" : CitySenderRef,
                            "CityRecipient" : CityRecipientRef,
                            "Weight" : "7",
                            "ServiceType" : "WarehouseWarehouse",
                            "Cost" : cost,
                            "CargoType" : "Cargo"

                        }
                    }

                ).then(response => {

                    if(response.data){
                        console.log('response.data ', response.data.data[0].Cost)
                        this.cost = response.data.data[0].Cost
                        //this.posts = response.data

                    }

                }).catch((error)=> {
                    // ловим ошибки
                    console.log('errors', error.response.data.errors)
                    if(error.response.data.errors){

                    }
                })
            },


        },
        computed: {
            alertCost(){
                if (this.cost){

                    if (this.price <= 1000 ){
                        return 50 + (this.cost)*50/100
                    }
                    if (this.price >= 1000 && this.price <= 3000){
                        return 50 + (this.cost)*30/100
                    }
                    if (this.price >= 3000 ){
                        return '0'
                    }
                }
                ``

                return null
            },


            formReady(){
                return Object.values(this.price).every(val => val.length > 0);
            }
        },
        mounted() {
            console.log('RealtyExampleComponent mounted111111.')
            //console.log(this.products)
        }
    }
</script>
