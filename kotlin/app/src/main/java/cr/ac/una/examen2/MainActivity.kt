package cr.ac.una.examen2

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.EditText
import android.widget.Toast
import cr.ac.una.examen2.activity.AddTrainingPlanActivity
import cr.ac.una.examen2.controller.TrainingPlanController

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
    }

    fun onLogin(@Suppress("UNUSED_PARAMETER") view: View) {
        // get txtUser
        val txtUser = findViewById<View>(R.id.txtUser) as EditText
        val user = txtUser.text.toString()

        if (user.isBlank()){
            Toast.makeText(this, "Put a valid user", Toast.LENGTH_LONG).show()
        }
        else{
            TrainingPlanController.username = user
            val intent = Intent(this, AddTrainingPlanActivity::class.java)
            startActivity(intent)
        }


    }
}