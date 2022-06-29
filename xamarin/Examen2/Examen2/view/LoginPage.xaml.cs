using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Examen2.view
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class LoginPage : ContentPage
    {
        public LoginPage()
        {
            InitializeComponent();
        }

        private async void btnLoginClicked(object sender, EventArgs e)
        {
            // check that name is not empty or null
            if(string.IsNullOrEmpty(txtName.Text))
            {
                await DisplayAlert("Error", "Name is required", "OK");
                txtName.Focus();
                return;
            }
            // show the TrainingPlanPage
            await Navigation.PushModalAsync(new TrainingPlanPage());
        }
    }
}