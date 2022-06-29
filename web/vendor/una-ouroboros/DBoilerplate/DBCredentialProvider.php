<?php
// /vendor/toml/Toml.php

namespace una_ouroboros\DBoilerplate;

use Arcesilas\Platform\Platform;

require_once realpath(dirname(__FILE__)) . '/../../toml/Toml.php';
require_once realpath(dirname(__FILE__)) . '/../../Arcesilas/Platform/Xdg.php';
require_once realpath(dirname(__FILE__)) . '/../../Arcesilas/Platform/Platform.php';

// clase diseñada para obtener las credenciales basada segun el desarrollo
class DBCredentialProvider
{
    protected $host;
    protected $user;
    protected $pass;
    protected $base;

    public function __construct($app, $database)
    {
        // ClearDB/Heroku
        $cleardb_env = getenv("CLEARDB_DATABASE_URL");

        if ($cleardb_env) {
            $cleardb_url = parse_url($cleardb_env);
            $this->host = $cleardb_url["host"];
            $this->user = $cleardb_url["user"];
            $this->pass = $cleardb_url["pass"];
            $this->base = substr($cleardb_url["path"], 1);
            return;
        }
        $host_env = getenv("PHPAPP_HOST");
        $user_env = getenv("PHPAPP_USER");
        $pass_env = getenv("PHPAPP_PASSWORD");
        $base_env = getenv("PHPBAPP_DB");
        // verificamos si todos los valores son validos
        if ($host_env && $user_env && $pass_env && $base_env) {
            $this->host = $host_env;
            $this->user = $user_env;
            $this->pass = $pass_env;
            $this->base = $base_env;
            return;
        }

        // no puede estar dentro de una carpeta accesible por el servidor web
        $base_path = Platform::getConfigDir();
        $toml_path = "{$base_path}/{$app}";
        $toml_name = "{$database}.toml";
        $full_path = "{$toml_path}/{$toml_name}";

        // check if DOCKER_DBOILERPLATE_CONFIG_FILE is set
        $docker_env = getenv("DOCKER_DBOILERPLATE_CONFIG_FILE");
        if ($docker_env) {
            $full_path = $docker_env;
        }

        // check if the environment variable DOCKER_DBOILERPLATE_DISABLE is set
        $docker_disable_env = getenv("DOCKER_DBOILERPLATE_DISABLE");
        if ($docker_disable_env) {
            throw new \Exception(
                "DOCKER_DBOILERPLATE_DISABLE is set," .
                    "please run /init-dboilerplate.py to initialize the database config"
            );
        }

        // si no existe el archivo toml, se crea uno por defecto
        if (!file_exists($full_path)) {
            $toml_string = $this->getDefaultTomlStr();
            // verificamos si existe el directorio
            if (!file_exists($toml_path)) {
                // lo creamos de forma recursiva
                mkdir($toml_path, 0777, true);
            }
            file_put_contents($full_path, $toml_string);
        }
        // cargo el archivo toml
        try {
            $result = json_decode(json_encode(\TOML::parseFile($full_path)), true);
            $this->host = $result["database"]["host"];
            $this->user = $result["database"]["user"];
            $this->pass = $result["database"]["pass"];
            $this->base = $result["database"]["base"];
        } catch (\Exception $e) {
            // relanzamos la excepcion, agregando que no pudimos cargar el archivo
            throw new \Exception("No se pudo cargar el archivo de configuracion", 0, $e);
        }
    }

    private function getDefaultTomlStr()
    {
        return
            '[database]' . "\n" .
            '   host = "localhost"' . "\n" .
            '   user = "root"' . "\n" .
            '   pass = ""' . "\n" .
            '   base = "DefaultDB"' . "\n";
    }
}
