<?php
namespace App\Services;

class Service
{

    public $model;

    public function getModel()
    {
        return $this->model::query();
    }

    public function add($params)
    {
        $this->model->fill($params);
        return $this->model->save();
    }

    public function getLastId()
    {
        return $this->model->id;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function update($params)
    {
        return $this->model->update($params);
    }
}
