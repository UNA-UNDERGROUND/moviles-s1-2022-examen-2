import os


# this script setups the listen to the heroku port
# do not run on your machine

def main():
    # check if the env variable is set
    if os.environ.get('PORT'):

        # get the port from the environment variable
        port = os.environ['PORT']
    
        # open the file
        with open('/etc/apache2/ports.conf', 'a') as f:
            # write the port to the file
            f.write(f'Listen {port}\n')
    
        # restart the apache service
        os.system('service apache2 restart')

if __name__ == "__main__":
    main()
    exit(0)