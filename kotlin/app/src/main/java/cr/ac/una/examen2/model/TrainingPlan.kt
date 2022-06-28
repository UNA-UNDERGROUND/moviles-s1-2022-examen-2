package cr.ac.una.examen2.model


import org.json.JSONArray
import org.json.JSONObject

class TrainingPlan {
    var id: Int? = null
    var name: String
    var username: String
    var activities: List<Activity>? = null

    constructor(id: Int?, name: String, username: String, activities: List<Activity>) {
        this.id = id
        this.name = name
        this.username = username
        this.activities = activities
        validate()
    }

    constructor(jsonObject: JSONObject){
        // id may be null
        if (jsonObject.has("id")) {
            this.id = jsonObject.getInt("id")
        }
        this.name = jsonObject.getString("name")
        this.username = jsonObject.getString("username")
        // activities be may null
        if (jsonObject.has("activities")) {
            val activitiesJsonArray = jsonObject.getJSONArray("activities")
            val activities = ArrayList<Activity>()
            for (i in 0 until activitiesJsonArray.length()) {
                activities.add(Activity(activitiesJsonArray.getJSONObject(i)))
            }
            this.activities = activities
        }
        validate()
    }

    private fun validate(){
        // name cannot be blank
        if(name.isBlank()){
            throw IllegalArgumentException("name cannot be blank")
        }
        // username cannot be blank
        if(username.isBlank()){
            throw IllegalArgumentException("username cannot be blank")
        }
    }

    fun toJSON(): JSONObject {
        val jsonObject = JSONObject()
        if (id != null) {
            jsonObject.put("id", id)
        }
        jsonObject.put("name", name)
        jsonObject.put("username", username)
        if (activities != null) {
            val activitiesJsonArray = JSONArray()
            for (activity in activities!!) {
                activitiesJsonArray.put(activity.toJSON())
            }
            jsonObject.put("activities", activitiesJsonArray)
        }
        return jsonObject
    }

    override fun toString(): String {
        return toJSON().toString()
    }
}