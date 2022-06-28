package cr.ac.una.examen2.model

import org.json.JSONObject
import java.util.*


class Activity {
    var id: Int? = null
    var idTrainingPlan: Int? = null
    var day: Day
    var name: String
    var repetitions: Int
    var breaks: Int
    var series: Int
    var cadence: Int
    var weight: Int

    constructor(
        id: Int?,
        idTrainingPlan: Int?,
        day: Day,
        name: String,
        repetitions: Int,
        breaks: Int,
        series: Int,
        cadence: Int,
        weight: Int
    ) {
        this.id = id
        this.idTrainingPlan = idTrainingPlan
        this.day = day
        this.name = name
        this.repetitions = repetitions
        this.breaks = breaks
        this.series = series
        this.cadence = cadence
        this.weight = weight
        validate()
    }


    // enum class for day
    // standing a id code and a char code
    enum class Day(var id: Int, var char: Char, var dayName: String) {
        MONDAY(1, 'M', "Monday"),
        TUESDAY(2, 'T', "Tuesday"),
        WEDNESDAY(3, 'W', "Wednesday"),
        THURSDAY(4, 'R', "Thursday"),
        FRIDAY(5, 'F', "Friday"),
        SATURDAY(6, 'S', "Saturday"),
        SUNDAY(7, 'U', "Sunday");

        companion object {
            fun getDayById(id: Int): Day {
                for (day in values()) {
                    if (day.id == id) {
                        return day
                    }
                }
                // if not throw exception
                throw IllegalArgumentException("Invalid day id: $id")
            }

            fun getDayByChar(char: String): Day {
                for (day in values()) {
                    val dayStr = day.char.toString()
                    if (dayStr.equals(char)) {
                        return day
                    }
                }
                // if not throw exception
                throw IllegalArgumentException("Invalid day char: $char")
            }

            fun getDayByName(dayName: String): Day {
                for (day in values()) {
                    // compare each value to lowercase the name
                    if (day.dayName.lowercase() == dayName.lowercase()) {
                        return day
                    }
                }
                // if not throw exception
                throw IllegalArgumentException("Invalid day name: $dayName")
            }
        }
    }

    // from JSON to Activity
    constructor(jsonObject: JSONObject) {
        // id may not be present
        if (jsonObject.has("id")) {
            id = jsonObject.getInt("id")
        }
        // idTrainingPlan may not be present
        if (jsonObject.has("idTrainingPlan")) {
            idTrainingPlan = jsonObject.getInt("idTrainingPlan")
        }
        // day is a string, so we need to convert it to a Day enum
        val day = jsonObject["day"] as String
        this.day = Day.getDayByChar(day)
        name = jsonObject["name"] as String
        repetitions = jsonObject["repetitions"] as Int
        breaks = jsonObject["breaks"] as Int
        series = jsonObject["series"] as Int
        cadence = jsonObject["cadence"] as Int
        weight = jsonObject["weight"] as Int
        validate()
    }

    // from Activity to JSON
    fun toJSON(): JSONObject {
        val jsonObject = JSONObject()
        // id may not be present
        if (id != null) {
            jsonObject.put("id", id)
        }
        // idTrainingPlan may not be present
        if (idTrainingPlan != null) {
            jsonObject.put("idTrainingPlan", idTrainingPlan)
        }
        // we need to get the char and convert it to a string
        val dayChar = day.char.toString()
        jsonObject.put("day", dayChar)
        jsonObject.put("name", name)
        jsonObject.put("repetitions", repetitions)
        jsonObject.put("breaks", breaks)
        jsonObject.put("series", series)
        jsonObject.put("cadence", cadence)
        jsonObject.put("weight", weight)
        return jsonObject
    }

    private fun validate() {
        // name cannot be blank
        if (name.isBlank()) {
            throw IllegalArgumentException("Name cannot be blank")
        }
        // repetitions must be greater than 0
        if (repetitions <= 0) {
            throw IllegalArgumentException("Repetitions must be greater than 0")
        }
        // breaks must not be negative
        if (breaks < 0) {
            throw IllegalArgumentException("Breaks must not be negative")
        }
        // series must not be negative
        if (series < 0) {
            throw IllegalArgumentException("Series must not be negative")
        }
        // cadence must not be negative
        if (cadence < 0) {
            throw IllegalArgumentException("Cadence must not be negative")
        }
        // weight must not be negative
        if (weight < 0) {
            throw IllegalArgumentException("Weight must not be negative")
        }
    }

}