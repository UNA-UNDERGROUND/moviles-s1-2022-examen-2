import appdirs

def get_config_dir(app_name):
    """
    Get the config dir
    """
    return appdirs.user_config_dir(app_name, False)