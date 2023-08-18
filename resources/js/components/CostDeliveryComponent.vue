<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <label for="">{{ trans2 }}</label>
                <div class="form-group d-flex me-2">

                    <select v-model="city.CitySenderRef" class="form-select form-select-lg mb-3"
                            aria-label=".form-select-lg example"
                            :class="{
                            'is-invalid': v$.city.CitySenderRef.$invalid || v$.city.CitySenderRef.$model === '',
                            'is-valid': v$.city.CitySenderRef.$model,
                            }"
                            @change="v$.city.CitySenderRef.$touch()"
                    >
                        <option disabled value="null">Місто відправлення (2 тестових)</option>
                        <option :value="'e718a680-4b33-11e4-ab6d-005056801329'">
                            {{ 'Київ' }}
                        </option>
                        <option :value="'e71abb60-4b33-11e4-ab6d-005056801329'">
                            {{ 'Львів' }}
                        </option>
                    </select>
                    <span class="text-danger" v-for="error in v$.city.CitySenderRef.$errors"
                          :key="error.$uid">
                        {{ error.$message}}
                    </span>
                </div>
                <label for="">{{ trans3 }}</label>
                <div class="form-group d-flex me-2">

                    <select v-model="selectedCity" class="form-select form-select-lg mb-3"
                            aria-label=".form-select-lg example" @change.prevent="getPost()"
                            :class="{
                            'is-invalid': v$.selectedCity.$invalid || v$.selectedCity.$model === '',
                            'is-valid': v$.selectedCity.$model,
                            }"
                            @change="v$.selectedCity.$touch()"
                    >
                        <option disabled value="null">Выберите Город</option>
                        <option v-for="(city,i) in cities" :key="city.id" :value="city">
                            {{ city.lang.title }}
                        </option>
                    </select>
                    <span class="text-danger" v-for="error in v$.selectedCity.$errors"
                          :key="error.$uid">
                        {{ error.$message}}
                    </span>

                </div>
                <template v-if="posts != 0">
                    <label for="">{{ trans7 }}</label>
                    <div class="form-group d-flex me-2">
                        <select v-model="selectedPost" class="form-select form-select-lg mb-3"
                                aria-label=".form-select-lg example"
                                :class="{
                            'is-invalid': v$.selectedPost.$invalid || v$.selectedPost.$model === '',
                            'is-valid': v$.selectedPost.$model,
                            }"
                                @change="v$.selectedPost.$touch()"
                        >
                            <option disabled value="null">Виберіть відділення</option>
                            <option v-for="(post,i) in posts" :key="post.id" :value="post">
                                {{ post.lang.title }}
                            </option>
                        </select>
                        <span class="text-danger" v-for="error in v$.selectedPost.$errors"
                              :key="error.$uid">
                        {{ error.$message}}
                    </span>
                    </div>
                </template>
                <div class="form-group">
                    <label>{{ trans8 }}</label>
                    <input  type="number"
                            min="1"
                             v-model.trim="price" class="form-control"
                           :class="{'is-invalid': ( v$.price.required.$invalid ), 'is-valid': ( !v$.price.required.$invalid ) }"
                           @click="v$.price.$touch()"
                    >
                    <span class="text-danger" v-for="error in v$.price.$errors"
                          :key="error.$uid">
                        {{ error.$message}}
                    </span>
                </div>
                <!-- if need button disabled when errors
                :disabled="!city.CitySenderRef || !selectedCity.id || !price"
                -->
                <button class="btn btn-success mt-4"
                        @click.prevent="getCost">
                    {{ trans5 }}
                </button>
                <!-- <cart-component></cart-component>-->
                <div class="card form-group d-flex me-2 mt-4"  style="height: 11rem;" v-if="alertCost !== null">
                    <ul>
                        <li> {{ trans6 }} - {{selectedCity?.lang?.title}}</li>
                        <li> {{ trans7 }} - {{selectedPost?.lang?.title}}</li>
                        <li> {{ trans4 }} {{ alertCost }} грн.</li>
                    </ul>

                </div>


            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import useVuelidate from '@vuelidate/core'
    import {required, minLength, maxLength, minValue, maxValue, integer, requiredIf,} from '@vuelidate/validators'

    export default {
        name: "CostDeliveryComponent",
        setup() {
            return {
                v$: useVuelidate(),
                /*validationConfig: {
                    $lazy: true,
                }*/
            }
        },
        validations() {
            return {
                city:{
                    CitySenderRef: {
                        required,
                    },
                },
                selectedCity: {
                    required,
                },
                selectedPost: {
                    required: requiredIf(function () {
                       // return this.required;
                        return this.selectedPost && this.selectedPost.length;
                        //return this.countries && this.countries.length && this.selectedAddress.country !== 'null';
                    }),
                },
                price: {
                    integer,
                    required,
                    minValue: minValue(1),
                    maxValue: maxValue(100000),
                },


            }
        },
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
        },
        data() {
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

            }
        },
        methods: {
            getPost() {
                let cityId = this.selectedCity.id
                this.cost = null
                axios.get('/posts/' + cityId).then(response => {

                    if (response.data) {

                        this.posts = response.data

                    }

                }).catch((error) => {
                    // ловим ошибки
                    if (error.response.data.errors) {

                    }
                })
            },
            getCost() {
                this.v$.$touch()
                if (this.v$.$error) {
                    let errorsstring = ''
                    for (var key in this.v$.$errors) {
                        errorsstring += "Поле: " + this.v$.$errors[key].$property + " - " + this.v$.$errors[key].$message + "\n"
                    }
                    alert(errorsstring);
                    return false
                }

                let CitySenderRef = this.city.CitySenderRef
                let CityRecipientRef = this.selectedCity.ref
                let cost = this.price
                axios.post('https://api.novaposhta.ua/v2.0/json/',
                    {
                        "apiKey": "",
                        "modelName": "InternetDocument",
                        "calledMethod": "getDocumentPrice",
                        "methodProperties": {
                            "CitySender": CitySenderRef,
                            "CityRecipient": CityRecipientRef,
                            "Weight": "7",
                            "ServiceType": "WarehouseWarehouse",
                            "Cost": cost,
                            "CargoType": "Cargo"

                        }
                    }
                ).then(response => {

                    if (response.data) {
                        this.cost = response.data.data[0].Cost


                    }

                }).catch((error) => {
                    // ловим ошибки
                    if (error.response.data.errors) {

                    }
                })
            },


        },
        computed: {
            alertCost() {
                if (this.cost) {

                    if (this.price <= 1000) {
                        return 50 + (this.cost) * 50 / 100
                    }
                    if (this.price >= 1000 && this.price <= 3000) {
                        return 50 + (this.cost) * 30 / 100
                    }
                    if (this.price >= 3000) {
                        return '0'
                    }
                }

                return null
            },

            formReady() {
                return Object.values(this.price).every(val => val.length > 0);
            }
        },
        mounted() {
        }
    }
</script>
