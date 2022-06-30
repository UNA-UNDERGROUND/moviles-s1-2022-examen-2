using System;
using System.Collections.Generic;
using System.Text;

using System.Threading.Tasks;
using Examen2.model;
using Newtonsoft.Json;

namespace Examen2.controller
{

    public class TrainingPlanController
    {
        //private static readonly string host = "https://examen2-moviles.xravn.net";
        private static readonly string host = "http://localhost:80";
        private static readonly string path = "/api/trainingPlan/";

        public string Username { get; }

        public TrainingPlanController(string username)
        {
            this.Username = username;
        }

        // async get training plans
        public async Task<List<TrainingPlan>> getTrainingPlans()
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
                    var trainingPlans = JsonConvert.DeserializeObject<List<TrainingPlan>>(json);
                    // return training plans
                    if (trainingPlans != null)
                    {
                        return trainingPlans;
                    }
                    else
                    {
                        return new List<TrainingPlan>();
                    }
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return new List<TrainingPlan>();
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return new List<TrainingPlan>();
            }
        }

        // add a training plan
        public async Task<TrainingPlan> addTrainingPlan(TrainingPlan trainingPlan)
        {
            var body = JsonConvert.SerializeObject(trainingPlan);
            var response = await RestController.Post(host + path, body);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var trainingPlanResponse = JsonConvert.DeserializeObject<TrainingPlan>(json);
                    // return training plan
                    if (trainingPlanResponse != null)
                    {
                        return trainingPlanResponse;
                    }
                    else
                    {
                        return new TrainingPlan();
                    }
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return new TrainingPlan();
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return new TrainingPlan();
            }
        }

        // update a training plan
        public async Task<bool> updateTrainingPlan(TrainingPlan trainingPlan)
        {
            var body = JsonConvert.SerializeObject(trainingPlan);
            var response = await RestController.Put(host + path + trainingPlan.id, body);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.Body;
                    // deserialize json
                    var trainingPlanResponse = JsonConvert.DeserializeObject<bool>(json);
                    // return training plan
                    return trainingPlanResponse;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return false;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return null
                    return false;
            }
        }

        // delete a training plan
        public async Task<bool> deleteTrainingPlan(TrainingPlan trainingPlan)
        {
            var response = await RestController.Delete(
                host + path + "?id=" + trainingPlan.id);
            // switch response code
            switch (response.StatusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // check for the response, is a boolean
                    return JsonConvert.DeserializeObject<bool>(response.Body);
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return false;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.StatusCode);
                    // return false
                    return false;
            }
        }
    }
}
