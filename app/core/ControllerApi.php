<?php

namespace app\core;

abstract class ControllerApi
{
	public $model;
    public $data;
    public $output_header = true;

	public function __construct(array $route = [])
    {
        if (!empty($route)) {
            $model_name = str_replace('Api','', $route['controller']);
            $this->model = $this->getModel($model_name);
        }
		$this->data = $this->getData();
	}

	public function getModel($name)
    {
		$path = 'app\models\\'.ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}

    public function response($data, $status = 'ok')
    {
        if ($this->output_header) {
            header("Access-Control-Allow-Orgin: *");
            header("Access-Control-Allow-Methods: *");
            header("Content-Type: application/json");
            header("HTTP/1.1 200 OK");
        }

        return json_encode(['status' => $status, 'data' => $data]);
    }

    private function getData()
    {
        return $_REQUEST;
    }

}