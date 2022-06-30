// See https://aka.ms/new-console-template for more information

using Examen2.model;
using Examen2.controller;
using Newtonsoft.Json;


try
{
    TrainingPlan trainingPlan = new TrainingPlan
    {
        id = null,
        name = "Training plan 1",
        username = "user1",
        activities = new List<Activity>{
        new Activity{
            id = null,
            idTrainingPlan = null,
            day = Activity.Day.Monday,
            name = "Push ups",
            repetitions = 10,
            breaks = 1,
            series = 3,
            cadence = 10,
            weight = 10
        },
        new Activity{
            id = null,
            idTrainingPlan = null,
            day = Activity.Day.Monday,
            name = "Pull ups",
            repetitions = 10,
            breaks = 1,
            series = 3,
            cadence = 10,
            weight = 10
        }
    }
    };

    TrainingPlanController trainingPlanController = new TrainingPlanController("user 1");


    Console.WriteLine("-----------------------------------------------------");
    // add the training plan to the server
    Console.WriteLine("Adding training plan...");
    var trainingPlanResponse = await trainingPlanController.addTrainingPlan(trainingPlan);
    Console.WriteLine(trainingPlanResponse.id);


    // fetch the training plans from the server
    Console.WriteLine("Fetching training plans...");
    var trainingPlans = await trainingPlanController.getTrainingPlans();
    // print the json of the training plans
    Console.WriteLine(JsonConvert.SerializeObject(trainingPlans));

    Console.WriteLine("-----------------------------------------------------");

    // update the training plan
    // first grab the training plan from the server
    trainingPlan = trainingPlans[0];
    trainingPlan.name = "Training plan 2";
    trainingPlan.activities[0].name = "Push ups 2";
    trainingPlan.activities[1].name = "Pull ups 2";
    // update the training plan on the server
    Console.WriteLine("Updating training plan...");
    var trainingPlanUpdateResponse = await trainingPlanController.updateTrainingPlan(
        trainingPlan);
    Console.WriteLine(trainingPlanUpdateResponse);

    // fetch again the training plans from the server
    Console.WriteLine("Fetching training plans...");
    var trainingPlans2 = await trainingPlanController.getTrainingPlans();
    // print the json of the training plans
    Console.WriteLine(JsonConvert.SerializeObject(trainingPlans2));

    Console.WriteLine("-----------------------------------------------------");
    // delete the first training plan from trainingPlans
    var trainingPlanToDelete = trainingPlans[0];
    Console.WriteLine("Deleting training plan...");
    var trainingPlanDeleteResponse 
        = await trainingPlanController.deleteTrainingPlan(trainingPlanToDelete);
    Console.WriteLine(trainingPlanDeleteResponse);


    // fetch again the training plans from the server
    Console.WriteLine("Fetching training plans...");
    var trainingPlans3 = await trainingPlanController.getTrainingPlans();
    // print the json of the training plans
    Console.WriteLine(JsonConvert.SerializeObject(trainingPlans3));
    Console.WriteLine("-----------------------------------------------------");
}
catch (System.Exception e)
{
    Console.WriteLine("Error" + e.Message);
}

// pause the console
Console.ReadLine();
