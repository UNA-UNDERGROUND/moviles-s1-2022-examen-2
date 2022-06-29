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
        private static readonly string host = "https://examen2-moviles.xravn.net";
        private static readonly string path = "/api/trainingPlan/";

        public string username { get; }

        public TrainingPlanController(string username)
        {
            this.username = username;
        }

        // async get training plans
        public async Task<List<TrainingPlan>> getTrainingPlans()
        {
            var response = await RestController.get(host + path);
            // switch response code
            switch (response.statusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.body;
                    // deserialize json
                    var trainingPlans = JsonConvert.DeserializeObject<List<TrainingPlan>>(json);
                    // return training plans
                    return trainingPlans;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.statusCode);
                    // return null
                    return null;
            }
        }

        // add a training plan
        public async Task<TrainingPlan> addTrainingPlan(TrainingPlan trainingPlan)
        {
            var body = JsonConvert.SerializeObject(trainingPlan);
            var response = await RestController.post(host + path, body);
            // switch response code
            switch (response.statusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.body;
                    // deserialize json
                    var trainingPlanResponse = JsonConvert.DeserializeObject<TrainingPlan>(json);
                    // return training plan
                    return trainingPlanResponse;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.statusCode);
                    // return null
                    return null;
            }
        }

        // update a training plan
        public async Task<TrainingPlan> updateTrainingPlan(TrainingPlan trainingPlan)
        {
            var body = JsonConvert.SerializeObject(trainingPlan);
            var response = await RestController.put(host + path + trainingPlan.id, body);
            // switch response code
            switch (response.statusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // get json
                    var json = response.body;
                    // deserialize json
                    var trainingPlanResponse = JsonConvert.DeserializeObject<TrainingPlan>(json);
                    // return training plan
                    return trainingPlanResponse;
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return null;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.statusCode);
                    // return null
                    return null;
            }
        }

        // delete a training plan
        public async Task<bool> deleteTrainingPlan(TrainingPlan trainingPlan)
        {
            var response = await RestController.delete(host + path + trainingPlan.id);
            // switch response code
            switch (response.statusCode)
            {
                // if ok
                case System.Net.HttpStatusCode.OK:
                    // check for the response, is a boolean
                    return JsonConvert.DeserializeObject<bool>(response.body);
                // if not found
                case System.Net.HttpStatusCode.NotFound:
                    return false;
                // if error
                default:
                    // log error
                    Console.WriteLine("Error: " + response.statusCode);
                    // return false
                    return false;
            }
        }
    }
}
