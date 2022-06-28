package cr.ac.una.examen2.controller

import cr.ac.una.examen2.BuildConfig
import cr.ac.una.examen2.controller.util.RestRequestController
import cr.ac.una.examen2.model.Activity
import cr.ac.una.examen2.model.TrainingPlan
import org.json.JSONObject

object ActivityController {

    var trainingPlan: TrainingPlan? = null


    fun getActivities(
        // on response callback
        onResponse: (activities: ArrayList<Activity>, code: Int) -> Unit,
        // on error callback
        onError: (error: String, code: Int) -> Unit
    ) {
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/activity/",
            "GET",
            null,
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                try {
                    val activities = ArrayList<Activity>()
                    val activitiesJson = response?.getJSONArray("data")
                    for (i in 0 until activitiesJson?.length()!!) {
                        val activityJSON = activitiesJson.getJSONObject(i)
                        val activity = Activity(activityJSON)
                        activities.add(activity)
                    }
                    onResponse(activities, code)
                } catch (e: Exception) {
                    onError(e.message!!, code)
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }

    fun addActivity(
        activity: Activity,
        // on response callback
        onResponse: (activity: Activity, code: Int) -> Unit,
        // on error callback
        onError: (error: String, code: Int) -> Unit
    ) {
        activity.idTrainingPlan = trainingPlan?.id!!
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/activity/",
            "POST",
            activity.toJSON()
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                try {
                    when (code) {
                        // se inserto correctamente
                        200 -> {
                            try {
                                val activity = Activity(response!!)
                                onResponse(activity, code)
                            } catch (e: Exception) {
                                onError(e.message!!, code)
                            }
                        }
                        409 -> {
                            onError("There is already an activity with the same name", code)
                        }
                    }
                } catch (e: Exception) {
                    onError(e.message!!, code)
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }

    fun deleteActivity(
        activity: Activity,
        // on response callback
        onDeleted: () -> Unit,
        // on error callback
        onError: (error: String, code: Int) -> Unit
    ) {
        activity.idTrainingPlan = trainingPlan?.id!!
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/activity/?id=" + activity.id,
            "DELETE",
            null
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                when (code) {
                    // se elimino correctamente
                    200 -> {
                        onDeleted()
                    }
                    404 -> {
                        onError("There is no activity with the id " + activity.id, code)
                    }
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }


    fun updateActivity(
        activity: Activity,
        onUpdate: () -> Unit,
        onError: (error: String, code: Int) -> Unit
    )
    {
        activity.idTrainingPlan = trainingPlan?.id!!
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/activity/",
            "PUT",
            activity.toJSON()
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                when (code) {
                    // se actualizo correctamente
                    200 -> {
                        onUpdate()
                    }
                    404 -> {
                        onError("There is no activity with the id " + activity.id, code)
                    }
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }

}


