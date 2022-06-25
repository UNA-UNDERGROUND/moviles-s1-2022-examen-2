# util script for run migrations onto a database
from common import db_credential_provider
import mysql.connector
import os
import sys


class DbMigrator:
    def __init__(self, app_name, database_environment):
        credential_provider = db_credential_provider.DBCredentialProvider(
            app_name, database_environment)
        self.credentials = credential_provider.get_credentials()

    def get_connection(self):
        conn = mysql.connector.connect(
            host=self.credentials['host'],
            user=self.credentials['user'],
            passwd=self.credentials['password'],
            database=self.credentials['database'])
        conn.autocommit = True
        return conn


    def wipe_database(self):
        print("Wiping database")
        # get wipe script and copy it to memory
        self_path = os.path.dirname(os.path.realpath(__file__))
        script_path = f"{self_path}/common/scripts/wipe.sql"
        with open(script_path, 'r') as script_file:
            script = script_file.read()
        # get connection
        connection = self.get_connection()
        # execute script
        vals = self.run_script(connection, script)
        for val in vals:
            print(val)

    def run_strategy(self, strategy):
        """
            Run a list of scripts for the given strategy
            the scripts of the given strategy are expected to be in the
            database-scripts folder
        """
        scripts_path = f"./sql/{strategy}"
        # get all files in the scripts path (only .sql files)
        files = [f for f in os.listdir(scripts_path) if f.endswith(".sql")]
        # get connection
        connection = self.get_connection()
        # iterate over all files
        for file in files:
            # get file path
            file_path = f"{scripts_path}/{file}"
            # get file content
            with open(file_path, 'r') as script_file:
                script = script_file.read()
            # execute script
            try:
                vals = self.run_script(connection, script)
                for val in vals:
                    print(val)
            except Exception as e:
                print(e)
                print(f"Error while executing script {file_path}")
                sys.exit(1)
        # close connection
        connection.close()

    def run_script(self, connection, script):
        vals = []
        cursor = connection.cursor()
        for result in cursor.execute(script, multi=True):
            var = result.fetchone()
            if var is not None:
                vals.append(var)
        cursor.close()
        connection.commit()
        return vals


if __name__ == '__main__':

    # get the arguments
    if len(sys.argv) < 3:
        print("Usage: db-migrator.py <app_name> <database_environment>")
        sys.exit(1)
    app_name = sys.argv[1]
    database_environment = sys.argv[2]
    db_migrator = DbMigrator(app_name, database_environment)
    # sets the list of strategies to use
    # along with their order
    strategies = [
        "wipe",
        "tables",
        "sample-data",
    ]
    if len(strategies) == 0:
        print("No strategies specified")
    else:
        for strategy in strategies:
            if strategy == "wipe":
                db_migrator.wipe_database()
            else:
                print(f"running strategy {strategy}.", end="")
                # run the strategy
                db_migrator.run_strategy(strategy)
                print(".. done")

