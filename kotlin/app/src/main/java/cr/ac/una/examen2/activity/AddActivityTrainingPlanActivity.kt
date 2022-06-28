package cr.ac.una.examen2.activity

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.constraintlayout.widget.ConstraintLayout
import androidx.recyclerview.widget.ItemTouchHelper
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import cr.ac.una.examen2.R
import cr.ac.una.examen2.activity.util.ActivityAdapter
import cr.ac.una.examen2.activity.util.SwipeToDeleteCallBack
import cr.ac.una.examen2.controller.ActivityController
import cr.ac.una.examen2.model.Activity

class AddActivityTrainingPlanActivity : AppCompatActivity() {
    private lateinit var recyclerActivity: RecyclerView
    private lateinit var layoutOriginalName: ConstraintLayout
    private lateinit var btnCancel: Button
    private lateinit var btnAdd: Button

    // original name, name, day(spinner), repetitions, breaks, series, cadence, weight
    private lateinit var txtOriginalName: EditText
    private lateinit var txtName: EditText
    private lateinit var spinnerDay: Spinner
    private lateinit var txtRepetitions: EditText
    private lateinit var txtBreaks: EditText
    private lateinit var txtSeries: EditText
    private lateinit var txtCadence: EditText
    private lateinit var txtWeight: EditText

    private var activity: Activity? = null

    val days = arrayOf("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_edit_activity)
        initComponents()
        onLoad()
    }

    private fun initComponents() {
        recyclerActivity = findViewById(R.id.recyclerActivity)
        layoutOriginalName = findViewById(R.id.layout_original_name_activity)
        btnCancel = findViewById(R.id.btnCancelActivity)
        btnAdd = findViewById(R.id.btnAddActivity)
        txtOriginalName = findViewById(R.id.txtOriginalNameActivity)
        txtName = findViewById(R.id.txtNameActivity)
        spinnerDay = findViewById(R.id.spinnerDayActivity)
        txtRepetitions = findViewById(R.id.txtRepetitions)
        txtBreaks = findViewById(R.id.txtBreaks)
        txtSeries = findViewById(R.id.txtSeries)
        txtCadence = findViewById(R.id.txtCadence)
        txtWeight = findViewById(R.id.txtWeight)

        spinnerDay.adapter =
            ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, days)
        // set the default value to Sunday
        spinnerDay.setSelection(0)

        recyclerActivity.apply {
            layoutManager = LinearLayoutManager(this@AddActivityTrainingPlanActivity)
            adapter = ActivityAdapter(ArrayList())
        }

        val swipeToDeleteCallBack = object : SwipeToDeleteCallBack() {
            override fun onSwiped(viewHolder: RecyclerView.ViewHolder, direction: Int) {
                val position = viewHolder.adapterPosition
                val activity =
                    (recyclerActivity.adapter as ActivityAdapter).getActivityAt(position)
                // if swipe to right, delete training plan
                // if swipe to left, edit training plan
                if (direction == ItemTouchHelper.LEFT) {
                    onDelete(activity)
                } else if (direction == ItemTouchHelper.RIGHT) {
                    onEdit(activity)
                }
            }
        }
        val itemTouchHelper = ItemTouchHelper(swipeToDeleteCallBack)
        itemTouchHelper.attachToRecyclerView(recyclerActivity)

    }

    private fun onLoad() {
        refreshData()
    }

    override fun onResume() {
        super.onResume()
        refreshData()
    }

    private fun onEdit(activity: Activity) {
        // show the button and the layout
        btnCancel.visibility = View.VISIBLE

        layoutOriginalName.visibility = View.VISIBLE
        // set the text of the original name
        txtOriginalName.setText(activity.name)
        // set the activity to edit
        this.activity = activity
        // set the values of the fields
        txtName.setText(activity.name)
        // get the day of the activity
        val day = activity.day
        // get the index of the day
        val index = days.indexOf(day.dayName)
        spinnerDay.setSelection(index)
        txtRepetitions.setText(activity.repetitions.toString())
        txtBreaks.setText(activity.breaks.toString())
        txtSeries.setText(activity.series.toString())
        txtCadence.setText(activity.cadence.toString())
        txtWeight.setText(activity.weight.toString())
        // set the name of the add button to edit
        btnAdd.text = getString(R.string.btn_edit)

    }


    private fun onDelete(activity: Activity) {
        ActivityController.deleteActivity(
            activity,
            {
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddActivityTrainingPlanActivity,
                            "Activity plan deleted",
                            Toast.LENGTH_SHORT
                        ).show()
                        refreshData()
                    }
                )

            },
            { error, code ->
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddActivityTrainingPlanActivity,
                            "Error deleting Activity plan",
                            Toast.LENGTH_SHORT
                        ).show()
                    }
                )
            }
        )
    }

    private fun addActivity(
        name: String,
        day: String,
        repetitions: Int,
        breaks: Int,
        series: Int,
        cadence: Int,
        weight: Int
    ) {
        val editMode = activity != null
        if (editMode) {
            activity?.name = name
            // get the day of the activity
            activity?.day = Activity.Day.getDayByName(day)
            activity?.repetitions = repetitions
            activity?.breaks = breaks
            activity?.series = series
            activity?.cadence = cadence
            activity?.weight = weight


            ActivityController.addActivity(
                activity!!,
                { activity, code ->
                    runOnUiThread(
                        Runnable {
                            Toast.makeText(
                                this@AddActivityTrainingPlanActivity,
                                "Training plan updated",
                                Toast.LENGTH_SHORT
                            ).show()
                            refreshData()
                        }
                    )
                },
                { error, code ->
                    runOnUiThread(
                        Runnable {
                            Toast.makeText(
                                this@AddActivityTrainingPlanActivity,
                                "Error updating activity plan",
                                Toast.LENGTH_SHORT
                            ).show()
                            // just unset the activity
                            activity = null
                        }
                    )
                }
            )
        } else {
            activity = Activity(
                null,
                null,
                Activity.Day.getDayByName(day),
                name,
                repetitions,
                breaks,
                series,
                cadence,
                weight
            )
            ActivityController.addActivity(
                activity!!,
                // on response callback lambda function (TrainingPlan, code)
                { activity, code ->
                    runOnUiThread(
                        Runnable {
                            if (code == 200) {
                                Toast.makeText(this, "activity added", Toast.LENGTH_LONG)
                                    .show()
                                refreshData()
                            } else {
                                Toast.makeText(
                                    this,
                                    "Error adding activity plan",
                                    Toast.LENGTH_LONG
                                )
                                    .show()
                            }
                        }
                    )

                },
                { error, code ->
                    runOnUiThread(
                        Runnable {
                            Toast.makeText(
                                this@AddActivityTrainingPlanActivity,
                                "Error adding activity: $error [$code]",
                                Toast.LENGTH_SHORT
                            ).show()
                        }
                    )
                }
            )
        }

    }

    private fun editActivity(
        name: String,
        day: String,
        repetitions: Int,
        breaks: Int,
        series: Int,
        cadence: Int,
        weight: Int,
        activity: Activity
    ) {
        activity.name = name
        activity.day = Activity.Day.getDayByName(day)
        activity.repetitions = repetitions
        activity.breaks = breaks
        activity.series = series
        activity.cadence = cadence
        activity.weight = weight

        ActivityController.updateActivity(
            activity,
            {
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddActivityTrainingPlanActivity,
                            "Activity updated",
                            Toast.LENGTH_SHORT
                        ).show()
                        refreshData()
                    }
                )

            },
            { error, code ->
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddActivityTrainingPlanActivity,
                            "Error updating Activity plan",
                            Toast.LENGTH_SHORT
                        ).show()
                    }
                )
            }
        )
    }


    fun onAddPlan(@Suppress("UNUSED_PARAMETER") view: View) {
        // check if all the fields are filled
        var incomplete = false
        if (txtName.text.isEmpty()) {
            txtName.error = "Name is required"
            incomplete = true
        }
        if (txtRepetitions.text.isEmpty()) {
            txtRepetitions.error = "Repetitions is required"
            incomplete = true
        }
        if (txtBreaks.text.isEmpty()) {
            txtBreaks.error = "Breaks is required"
            incomplete = true
        }
        if (txtSeries.text.isEmpty()) {
            txtSeries.error = "Series is required"
            incomplete = true
        }
        if (txtCadence.text.isEmpty()) {
            txtCadence.error = "Cadence is required"
            incomplete = true
        }
        if (txtWeight.text.isEmpty()) {
            txtWeight.error = "Weight is required"
            incomplete = true
        }
        if (incomplete) {
            Toast.makeText(
                this,
                "Please fill all the fields",
                Toast.LENGTH_SHORT
            ).show()
            return
        }


        val name = txtName.text.toString()
        val day = spinnerDay.selectedItem.toString()
        val repetitions = txtRepetitions.text.toString().toInt()
        val breaks = txtBreaks.text.toString().toInt()
        val series = txtSeries.text.toString().toInt()
        val cadence = txtCadence.text.toString().toInt()
        val weight = txtWeight.text.toString().toInt()

        // get the plan list from the adapter
        val activityList = (recyclerActivity.adapter as ActivityAdapter).getActivityList()
        // check if the plan name is not empty
        if (name.isBlank()) {
            Toast.makeText(this, "Plan name is empty", Toast.LENGTH_LONG).show()
            return
        } else {
            // check if we need to edit the plan or add a new one
            if (activity != null) {
                editActivity(name, day, repetitions, breaks, series, cadence, weight, activity!!)
                return
            }
            // check if the plan name is not already in the list
            for (activity in activityList) {
                if (activity.name == name) {
                    Toast.makeText(
                        this,
                        "Activity name already exists",
                        Toast.LENGTH_LONG
                    ).show()
                    return
                }
            }
            // if the plan name is not in the list, add it
            addActivity(name, day, repetitions, breaks, series, cadence, weight)
        }
    }

    fun onCancel(@Suppress("UNUSED_PARAMETER") view: View) {
        // refreshing the data will clear the text fields
        // and set to null the training plan variable
        refreshData()
    }

    private fun refreshData() {
        // reset the activity
        activity = null
        // resetting the text fields
        txtName.setText("")
        txtRepetitions.setText("")
        txtBreaks.setText("")
        txtSeries.setText("")
        txtCadence.setText("")
        txtWeight.setText("")
        // resetting the spinner to the first item
        spinnerDay.setSelection(0)
        // hide the button to cancel and the layout for the original name
        btnCancel.visibility = View.GONE
        layoutOriginalName.visibility = View.GONE
        // set the button to add to the original text
        btnAdd.text = getString(R.string.btn_add)
        runOnUiThread {
            val trainingPlanId = ActivityController.trainingPlan!!.id
            ActivityController.getActivities(
                // on response callback lambda function (List<TrainingPlan>, code)
                { activities, code ->
                    runOnUiThread(
                        Runnable {
                            if (code == 200) {
                                // list adapter
                                val list = activities.filter { it.idTrainingPlan == trainingPlanId }
                                val adapter = ActivityAdapter(list)
                                recyclerActivity.adapter = adapter
                            } else {
                                Toast.makeText(
                                    this,
                                    "Error getting activities",
                                    Toast.LENGTH_LONG
                                ).show()
                            }
                        }
                    )
                },
                { error, code ->
                    runOnUiThread(Runnable {
                        Toast.makeText(
                            this,
                            "Error getting activities, error: " +
                                    "$error [$code]", Toast.LENGTH_LONG
                        )
                            .show()
                    })
                }
            )
        }

    }
}