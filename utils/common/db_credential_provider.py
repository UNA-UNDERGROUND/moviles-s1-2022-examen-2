# provides the connection information for the database
# add current directory to search path
import os
import sys
sys.path.append(os.path.dirname(os.path.realpath(__file__)))

from configuration import heroku_config, environment_var_config, toml_config


class DBCredentialProvider:

    # creates a new instance of the DBCredentialProvider class
    # @param app_name the name of the application
    # @param database_enviroment the name of the database environment
    def __init__(self, app_name, database_environment):
        # try in the following order:
        # 1. heroku config
        # 2. environment variables
        # 3. toml config
        cleardb_config = heroku_config.get_heroku_config()
        if cleardb_config is not None:
            self.set_credentials(
                cleardb_config['host'],
                cleardb_config['user'],
                cleardb_config['password'],
                cleardb_config['database'])
            return
        env_config = environment_var_config.get_env_config()
        if env_config is not None:
            self.set_credentials(
                env_config['host'],
                env_config['user'],
                env_config['password'],
                env_config['database'])
            return
        file_config = toml_config.get_toml_config(app_name, database_environment)
        if file_config is not None:
            self.set_credentials(
                file_config['host'],
                file_config['user'],
                file_config['password'],
                file_config['database'])
            return
        raise(Exception("No database configuration found"))


    def set_credentials(self, host, user, password, database):
        self.credentials = {
            'host': host,
            'user': user,
            'password': password,
            'database': database
        }

    def get_credentials(self):
        return self.credentials


if __name__ == "__main__":
    db_credential_provider = DBCredentialProvider("examen", "local")
    credentials = db_credential_provider.get_credentials()
    print(credentials)

