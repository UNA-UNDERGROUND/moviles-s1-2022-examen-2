import os


def get_heroku_config():
    """
    Get the heroku config from the environment variables
    """
    cleardb_env = os.environ.get('CLEARDB_DATABASE_URL')

    if cleardb_env is None:
        return None

    return {
        "host": cleardb_env.split("@")[1].split(":")[0],
        "user": cleardb_env.split("//")[1].split(":")[0],
        "password": cleardb_env.split("//")[1].split(":")[1].split("/")[0],
        "database": cleardb_env.split("//")[1].split(":")[1].split("/")[1].split("?")[0]
    }
