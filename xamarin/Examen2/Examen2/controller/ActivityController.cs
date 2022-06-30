using System;
using System.Collections.Generic;
using System.Text;

using System.Threading.Tasks;
using Examen2.model;
using Newtonsoft.Json;

namespace Examen2.controller
{
    public class ActivityController
    {
        private static readonly string host = "https://examen2-moviles.xravn.net";
        private static readonly string path = "/api/activity/";

        public TrainingPlan trainingPlan { get; }

        public ActivityController(TrainingPlan trainingPlan)
        {
            this.trainingPlan = trainingPlan;
        }

        // async get activities
        public async Task<List<Activity>> getActivities()
        {
            var response = await RestController.Get(host + path);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var activities = JsonConvert.DeserializeObject<List<Activity>>(json);
                    // return activities
                    return activities;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return null;
            }
        }

        // add an activity
        public async Task<Activity> addActivity(Activity activity)
        {
            var body = JsonConvert.SerializeObject(activity);
            var response = await RestController.Post(host + path, body);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var newActivity = JsonConvert.DeserializeObject<Activity>(json);
                    // return activity
                    return newActivity;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return null;
            }
        }

        // update an activity
        public async Task<Activity> updateActivity(Activity activity)
        {
            var body = JsonConvert.SerializeObject(activity);
            var response = await RestController.Put(host + path, body);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var updatedActivity = JsonConvert.DeserializeObject<Activity>(json);
                    // return activity
                    return updatedActivity;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return null;
            }
        }

        // delete an activity
        public async Task<Activity> deleteActivity(Activity activity)
        {
            var response = await RestController.Delete(host + path + activity.id);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var deletedActivity = JsonConvert.DeserializeObject<Activity>(json);
                    // return activity
                    return deletedActivity;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return null;
            }
        }

    }
}
