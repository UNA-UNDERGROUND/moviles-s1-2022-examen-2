package cr.ac.una.examen2.activity

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.constraintlayout.widget.ConstraintLayout
import androidx.recyclerview.widget.ItemTouchHelper
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import cr.ac.una.examen2.R
import cr.ac.una.examen2.activity.util.SwipeToDeleteCallBack
import cr.ac.una.examen2.activity.util.TrainingPlanAdapter
import cr.ac.una.examen2.controller.TrainingPlanController
import cr.ac.una.examen2.model.TrainingPlan

class AddTrainingPlanActivity : AppCompatActivity() {
    private lateinit var recyclerTrainingPlan: RecyclerView
    private lateinit var btnCancel: Button
    private lateinit var btnAdd: Button
    private lateinit var txtOriginalName: EditText
    private lateinit var txtNewName: EditText
    private lateinit var layoutOriginalName: ConstraintLayout
    private var trainingPlan: TrainingPlan? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_training_plan)
        initComponents()
        onLoad()
    }

    private fun initComponents() {
        recyclerTrainingPlan = findViewById(R.id.recyclerTrainingPlan)
        btnCancel = findViewById(R.id.btnCancel)
        btnAdd = findViewById(R.id.btnAdd)
        txtOriginalName = findViewById(R.id.txtOriginalName)
        txtNewName = findViewById(R.id.txtName)
        layoutOriginalName = findViewById(R.id.layout_original_name)

        recyclerTrainingPlan.apply {
            layoutManager = LinearLayoutManager(this@AddTrainingPlanActivity)
            adapter = TrainingPlanAdapter(ArrayList<TrainingPlan>())
        }

        val swipeToDeleteCallBack = object : SwipeToDeleteCallBack() {
            override fun onSwiped(viewHolder: RecyclerView.ViewHolder, direction: Int) {
                val position = viewHolder.adapterPosition
                val trainingPlan =
                    (recyclerTrainingPlan.adapter as TrainingPlanAdapter).getTrainingPlanAt(position)
                // if swipe to right, delete training plan
                // if swipe to left, edit training plan
                if (direction == ItemTouchHelper.LEFT) {
                    onDelete(trainingPlan)
                } else if (direction == ItemTouchHelper.RIGHT) {
                    onEdit(trainingPlan)
                }
            }
        }
        val itemTouchHelper = ItemTouchHelper(swipeToDeleteCallBack)
        itemTouchHelper.attachToRecyclerView(recyclerTrainingPlan)

    }

    private fun onLoad() {
        refreshData()
    }

    override fun onResume() {
        super.onResume()
        refreshData()
    }

    private fun onEdit(trainingPlan: TrainingPlan) {
        // show the button and the layout
        btnCancel.visibility = View.VISIBLE
        layoutOriginalName.visibility = View.VISIBLE
        // set the text of the original name
        txtOriginalName.setText(trainingPlan.name)
        // set the training plan to edit
        this.trainingPlan = trainingPlan
        // set the new name to the text field
        txtNewName.setText(trainingPlan.name)
        // set the name of the add button to edit
        btnAdd.text = getString(R.string.btn_edit)

    }


    private fun onDelete(trainingPlan: TrainingPlan) {
        TrainingPlanController.deleteTrainingPlan(
            trainingPlan,
            {
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddTrainingPlanActivity,
                            "Training plan deleted",
                            Toast.LENGTH_SHORT
                        ).show()
                        refreshData()
                    }
                )

            },
            { error ->
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddTrainingPlanActivity,
                            "Error deleting training plan",
                            Toast.LENGTH_SHORT
                        ).show()
                    }
                )
            }
        )
    }

    private fun addPlan(name: String, username: String) {
        val editMode = trainingPlan != null
        if (editMode) {
            trainingPlan?.name = name
            trainingPlan?.username = username
            TrainingPlanController.updateTrainingPlan(
                trainingPlan!!,
                {
                    runOnUiThread(
                        Runnable {
                            Toast.makeText(
                                this@AddTrainingPlanActivity,
                                "Training plan updated",
                                Toast.LENGTH_SHORT
                            ).show()
                            refreshData()
                        }
                    )
                },
                { error ->
                    runOnUiThread(
                        Runnable {
                            Toast.makeText(
                                this@AddTrainingPlanActivity,
                                "Error updating training plan",
                                Toast.LENGTH_SHORT
                            ).show()
                        }
                    )
                }
            )
        } else {
            trainingPlan = TrainingPlan(null, name, username, ArrayList())
            TrainingPlanController.addTrainingPlan(
                trainingPlan!!,
                // on response callback lambda function (TrainingPlan, code)
                { trainingPlan, code ->
                    runOnUiThread(
                        Runnable {
                            if (code == 200) {
                                Toast.makeText(this, "Training plan added", Toast.LENGTH_LONG)
                                    .show()
                                refreshData()
                            } else {
                                Toast.makeText(
                                    this,
                                    "Error adding training plan",
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
                                this@AddTrainingPlanActivity,
                                "Error adding training plan",
                                Toast.LENGTH_SHORT
                            ).show()
                        }
                    )
                }
            )
        }

    }

    private fun editPlan(name: String, plan: TrainingPlan) {
        plan.name = name
        TrainingPlanController.updateTrainingPlan(
            plan,
            {
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddTrainingPlanActivity,
                            "Training plan updated",
                            Toast.LENGTH_SHORT
                        ).show()
                        refreshData()
                    }
                )

            },
            { error ->
                runOnUiThread(
                    Runnable {
                        Toast.makeText(
                            this@AddTrainingPlanActivity,
                            "Error updating training plan",
                            Toast.LENGTH_SHORT
                        ).show()
                    }
                )
            }
        )
    }


    fun onAddPlan(@Suppress("UNUSED_PARAMETER") view: View) {
        val name = txtNewName.text.toString()
        val username = TrainingPlanController.username
        // get the plan list from the adapter
        val planList = (recyclerTrainingPlan.adapter as TrainingPlanAdapter).getTrainingPlanList()
        // check if the plan name is not empty
        if (name.isBlank()) {
            Toast.makeText(this, "Plan name is empty", Toast.LENGTH_LONG).show()
            return
        } else {
            // check if the plan name is not already in the list
            for (plan in planList) {
                if (plan.name == name) {
                    editPlan(name, plan)
                    return
                }
            }
            // if the plan name is not in the list, add it
            addPlan(name, username)
        }
    }

    fun onCancel(@Suppress("UNUSED_PARAMETER") view: View) {
        // refreshing the data will clear the text fields
        // and set to null the training plan variable
        refreshData()
    }

    fun refreshData() {
        // resetting the text fields
        txtNewName.setText("")
        // hide the button to cancel and the layout for the original name
        btnCancel.visibility = View.GONE
        layoutOriginalName.visibility = View.GONE
        // set the button to add to the original text
        btnAdd.text = getString(R.string.btn_add)
        runOnUiThread {
            val username = TrainingPlanController.username
            TrainingPlanController.getTrainingPlans(
                // on response callback lambda function (List<TrainingPlan>, code)
                { trainingPlans, code ->
                    runOnUiThread(
                        Runnable {
                            if (code == 200) {
                                // list adapter
                                val list = trainingPlans.filter { it.username == username }
                                val adapter = TrainingPlanAdapter(list)
                                recyclerTrainingPlan.adapter = adapter
                            } else {
                                Toast.makeText(
                                    this,
                                    "Error getting training plans",
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
                            "Error getting training plans, error: " +
                                    "$error [$code]", Toast.LENGTH_LONG
                        )
                            .show()
                    })
                }
            )
        }

    }
}