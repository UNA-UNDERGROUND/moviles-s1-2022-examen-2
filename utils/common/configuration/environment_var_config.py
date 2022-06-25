import os
import dotenv


def get_env_config():
    """
    Get the environment config from the environment variables
    """
    dotenv.load_dotenv()
    host_env = os.environ.get('PHPAPP_HOST')
    user_env = os.environ.get('PHPAPP_USER')
    password_env = os.environ.get('PHPAPP_PASSWORD')
    database_env = os.environ.get('PHPAPP_DB')

    if all(v is None for v in [host_env, user_env, password_env, database_env]):
        return None

    return {
        "host": host_env,
        "user": user_env,
        "password": password_env,
        "database": database_env
    }
