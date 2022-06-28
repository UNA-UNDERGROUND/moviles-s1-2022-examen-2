package cr.ac.una.examen2.activity.util

import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.TextView
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import cr.ac.una.examen2.R
import cr.ac.una.examen2.activity.AddActivityTrainingPlanActivity
import cr.ac.una.examen2.controller.ActivityController
import cr.ac.una.examen2.model.TrainingPlan

class TrainingPlanAdapter(private val list: List<TrainingPlan>) :
    RecyclerView.Adapter<TrainingPlanViewHolder>() {
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): TrainingPlanViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        return TrainingPlanViewHolder(inflater, parent)
    }

    override fun onBindViewHolder(holder: TrainingPlanViewHolder, position: Int) {
        val trainingPlan: TrainingPlan = list[position]
        holder.bind(trainingPlan)
    }

    override fun getItemCount(): Int = list.size
    fun getTrainingPlanAt(position: Int): TrainingPlan {
        return list[position]
    }

    fun getTrainingPlanList(): List<TrainingPlan> {
        return list
    }
}


class TrainingPlanViewHolder(inflater: LayoutInflater, parent: ViewGroup) :
    RecyclerView.ViewHolder(inflater.inflate(R.layout.training_plan_item, parent, false)) {

    private lateinit var trainingPlan: TrainingPlan

    fun bind(trainingPlan: TrainingPlan) {
        this.trainingPlan = trainingPlan
        val txtName = itemView.findViewById<TextView>(R.id.txtNameTrainingItem)
        txtName.text = trainingPlan.name
        val btnView = itemView.findViewById<TextView>(R.id.btnViewTrainingPlan)
        btnView.setOnClickListener {
            onPress()
        }
    }

    fun onPress() {
        trainingPlan?.let {
            // set the training plan to the controller
            // and start the training plan activity
            ActivityController.trainingPlan = trainingPlan
            val intent = Intent(itemView.context, AddActivityTrainingPlanActivity::class.java)
            itemView.context.startActivity(intent)
        }
    }

}