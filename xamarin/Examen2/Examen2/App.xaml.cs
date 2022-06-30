using System;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Examen2
{
    public partial class App : Application
    {
        public App()
        {
            InitializeComponent();
            // catch all unhandled exceptions
            AppDomain.CurrentDomain.UnhandledException += CurrentDomain_UnhandledException;

            MainPage = new view.LoginPage();
        }

        private void CurrentDomain_UnhandledException(object sender, UnhandledExceptionEventArgs e)
        {
            // log error
            Console.WriteLine("Error: " + e.ExceptionObject);
        }

        protected override void OnStart()
        {
        }

        protected override void OnSleep()
        {
        }

        protected override void OnResume()
        {
        }
    }
}
