from . import path_provider
import toml


def get_toml_config(app, environment):
    """
    Get the toml config from the environment variables
    """
    config_dir = path_provider.get_config_dir(app)
    config_file_path = f"{config_dir}/{environment}.toml"
    try:
        config = toml.load(config_file_path)
        return {
            "host": config["database"]["host"],
            "user": config["database"]["user"],
            "password": config["database"]["pass"],
            "database": config["database"]["base"] 
        }
    except FileNotFoundError:
        return None
