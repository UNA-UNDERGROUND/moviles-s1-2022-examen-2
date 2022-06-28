package cr.ac.una.examen2.controller.util


import okhttp3.MediaType
import okhttp3.OkHttpClient
import okhttp3.Request
import okhttp3.RequestBody
import org.json.JSONArray
import org.json.JSONObject

// class that handles the request and response of the application
// to the service
// requires a path, method and body(optional, must be a JSONObject)
abstract class RestRequestController(// path
    private val path: String, // method
    private val method: String, // body
    private val body: JSONObject?
) {

    private val client = OkHttpClient()

    private fun handleResponse(response: String, code: Int) {
        try {
            if (response.isBlank()) {
                onResponse(null, code)
            } else if (response.startsWith("{")) {
                onResponse(JSONObject(response), code)
            } else if (response.startsWith("[")) {
                var jsonArray = JSONArray(response)
                // wrap the array in a JSONObject to make it compatible with the onResponse method
                val jsonObject = JSONObject()
                jsonObject.put("data", jsonArray)
                onResponse(jsonObject, code)
            } else {
                onResponse(null, code)
            }
        } catch (e: Exception) {
            onParseError(e.message!!, code)
        }
    }

    protected abstract fun onResponse(response: JSONObject?, code: Int)
    protected abstract fun onParseError(error: String, code: Int)

    // request to the service
    fun request() {

        val requestBody: RequestBody =
            RequestBody.create(
                jsonMediaType,
                body?.toString() ?: ""
            )


        val requestBuilder = Request.Builder()
            .url(path)
        when (method) {
            "GET" -> requestBuilder.get()
            "POST" -> requestBuilder.post(requestBody)
            "PUT" -> requestBuilder.put(requestBody)
            "DELETE" -> requestBuilder.delete(RequestBody.create(MediaType.parse("text/plain"), ""))
            else -> throw IllegalArgumentException("Invalid method")
        }
        val request = requestBuilder.build()


        Thread {
            try {
                client.newCall(request).execute().use { response ->
                    // get the status code
                    val statusCode = response.code()
                    // get the response body
                    val responseBody = response.body()?.string()
                    // run on a new thread
                    Thread {
                        handleResponse(responseBody.toString(), statusCode)
                    }.start()
                }
            } catch (e: Exception) {
                handleResponse(e.message!!, -1)
            }
        }.start()


    }

    companion object {
        val jsonMediaType: MediaType = MediaType.get("application/json; charset=utf-8")
    }
}