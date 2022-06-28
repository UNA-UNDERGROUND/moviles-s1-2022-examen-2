package cr.ac.una.examen2.controller

import cr.ac.una.examen2.BuildConfig
import cr.ac.una.examen2.controller.util.RestRequestController
import cr.ac.una.examen2.model.TrainingPlan
import org.json.JSONObject

object TrainingPlanController {

    var username = ""

    fun getTrainingPlans(
        // on response callback
        onResponse: (trainingPlans: List<TrainingPlan>, code: Int) -> Unit,
        // on error callback
        onError: (error: String, code: Int) -> Unit
    ) {
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/trainingPlan/",
            "GET",
            null,
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                try {
                    val trainingPlans = ArrayList<TrainingPlan>()
                    val trainingPlanArray = response?.getJSONArray("data")
                    for (i in 0 until trainingPlanArray?.length()!!) {
                        val jsonTrainingPlan = trainingPlanArray.getJSONObject(i)
                        val trainingPlan = TrainingPlan(jsonTrainingPlan)
                        trainingPlans.add(trainingPlan)
                    }
                    onResponse(trainingPlans, code)
                } catch (e: Exception) {
                    onError(e.message ?: "Error", code)
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }

    fun addTrainingPlan(
        trainingPlan: TrainingPlan,
        // on response callback
        onResponse: (trainingPlan: TrainingPlan, code: Int) -> Unit,
        // on error callback
        onError: (error: String, code: Int) -> Unit
    ) {
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/trainingPlan/",
            "POST",
            trainingPlan.toJSON(),
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                try {
                    when (code) {
                        // se inserto correctamente
                        200 -> {
                            try {
                                val trainingPlan = TrainingPlan(response!!)
                                onResponse(trainingPlan, code)
                            } catch (e: Exception) {
                                onError(e.message ?: "Error", code)
                            }
                        }
                        // ya existe un trainingPlan con ese nombre
                        409 -> {
                            onError(response?.getString("message") ?: "Error", code)
                        }
                    }
                } catch (e: Exception) {
                    onError(e.message ?: "Error", code)
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error, code)
            }
        }
        requestController.request()
    }

    fun deleteTrainingPlan(
        trainingPlan: TrainingPlan,
        onDeleted: () -> Unit,
        onError: (error: String) -> Unit
    ) {
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/trainingPlan/?id=" + trainingPlan.id,
            "DELETE",
            null,
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                when (code) {
                    // se elimino correctamente
                    200 -> {
                        onDeleted()
                    }
                    // no existe un trainingPlan con ese id
                    404 -> {
                        onError(response?.getString("message") ?: "Error")
                    }
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error)
            }
        }
        requestController.request()

    }

    fun updateTrainingPlan(
        trainingPlan: TrainingPlan,
        onUpdate: () -> Unit,
        onError: (error: String) -> Unit
    ) {
        val requestController = object : RestRequestController(
            BuildConfig.API_EXAMEN_FQDN + "/api/trainingPlan/",
            "PUT",
            trainingPlan.toJSON(),
        ) {
            override fun onResponse(response: JSONObject?, code: Int) {
                when (code) {
                    // se elimino correctamente
                    200 -> {
                        onUpdate()
                    }
                    // no existe un trainingPlan con ese id
                    404 -> {
                        onError(response?.getString("message") ?: "Error")
                    }
                }
            }

            override fun onParseError(error: String, code: Int) {
                onError(error)
            }
        }
        requestController.request()
    }

}