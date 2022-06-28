package cr.ac.una.examen2.activity.util

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import cr.ac.una.examen2.R
import cr.ac.una.examen2.model.Activity

class ActivityAdapter(private val list: List<Activity>) :
    RecyclerView.Adapter<ActivityViewHolder>() {
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ActivityViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        return ActivityViewHolder(inflater, parent)
    }

    override fun onBindViewHolder(holder: ActivityViewHolder, position: Int) {
        val activity: Activity = list[position]
        holder.bind(activity)
    }

    override fun getItemCount(): Int = list.size

    fun getActivityAt(position: Int): Activity {
        return list[position]
    }

    fun getActivityList(): List<Activity> {
        return list
    }

}

class ActivityViewHolder(inflater: LayoutInflater, parent: ViewGroup) :
    RecyclerView.ViewHolder(inflater.inflate(R.layout.activity_item, parent, false)) {

    private lateinit var activity: Activity

    fun bind(activity: Activity) {
        this.activity = activity
        // set the text views to the values of the current activity
        val txtActivityName = itemView.findViewById<android.widget.TextView>(R.id.txtActivityName)
        val txtActivityDay = itemView.findViewById<android.widget.TextView>(R.id.txtActivityDay)
        val txtActivityRepetitions =
            itemView.findViewById<android.widget.TextView>(R.id.txtRepetitionsActivity)
        val txtActivityBreaks =
            itemView.findViewById<android.widget.TextView>(R.id.txtActivityBreaks)
        val txtActivitySeries =
            itemView.findViewById<android.widget.TextView>(R.id.txtActivitySeries)
        val txtActivityCadence =
            itemView.findViewById<android.widget.TextView>(R.id.txtActivityCadence)
        val txtActivityWeight =
            itemView.findViewById<android.widget.TextView>(R.id.txtActivityWeight)

        txtActivityName.text = activity.name
        txtActivityDay.text = activity.day.dayName
        txtActivityRepetitions.text = activity.repetitions.toString()
        txtActivityBreaks.text = activity.breaks.toString()
        txtActivitySeries.text = activity.series.toString()
        txtActivityCadence.text = activity.cadence.toString()
        txtActivityWeight.text = activity.weight.toString()

    }


}
