
import os


def main() -> None:
    """
    Main function
    """
    # check if the environment variable DOCKER_DBOILERPLATE_DISABLE is set to 0
    if os.environ.get("DOCKER_DBOILERPLATE_DISABLE") == "0":
        print("DBoilerplate is already configured")
        print("if you want to reconfigure, please set the environment variable DOCKER_DBOILERPLATE_DISABLE to 1")
        return
    # get the host, user , pass and base
    print("DBoilerplate container configurator")
    host = input("Enter the host: ")
    user = input("Enter the user: ")
    passwd = input("Enter the password: ")
    base = input("Enter the base: ")
    # create the config file(TOML)
    file_path = "/config/DBoilerplate.toml"
    # edit the file in truncate mode
    with open(file_path, "w") as f:
        print("creating the config file")
        """
        [database]
            host = {host}
            user = {user}
            pass = {pass}
            base = {base}
        """
        # identate the file with tabs
        f.write(f"[database]\n")
        f.write(f"\thost = \"{host}\"\n")
        f.write(f"\tuser = \"{user}\"\n")
        f.write(f"\tpass = \"{passwd}\"\n")
        f.write(f"\tbase = \"{base}\"\n")
        # set the environment variable DOCKER_DBOILERPLATE_DISABLE to 0
        os.environ.pop("DOCKER_DBOILERPLATE_DISABLE", None)
        # add the environment variable DOCKER_DBOILERPLATE_CONFIG_FILE
        os.environ["DOCKER_DBOILERPLATE_CONFIG_FILE"] = file_path
        # print the message
        print("Config file created")
    print("restarting the apache2 service")
    # restart the apache2 service
    os.system("service apache2 restart")
    print("apache2 service restarted")
    print("DBOilerplate container configurator finished")


# main
if __name__ == "__main__":
    main()
    exit(0)
