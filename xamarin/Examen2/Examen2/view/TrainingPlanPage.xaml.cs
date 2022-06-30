using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

using Examen2.controller;
using Examen2.model;

namespace Examen2.view
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class TrainingPlanPage : ContentPage
    {

        private TrainingPlanController controller;
        // internal list of training plans
        private List<TrainingPlan> trainingPlans = new List<TrainingPlan>();
        
        public TrainingPlanPage(TrainingPlanController controller)
        {
            InitializeComponent();
            this.controller = controller;
            // load data asyncronously
            Task.Run(async () =>
            {
                await LoadData();
            }).Start();
        }


        private void OnEditSwipeItemInvoked(object sender, EventArgs e)
        {

        }

        private void OnDeleteSwipeItemInvoked(object sender, EventArgs e)
        {

        }

        private void BtnAddClicked(object sender, EventArgs e)
        {

        }

        private void BtnCancelClicked(object sender, EventArgs e)
        {
            txtOriginalName = null;
        }


        // request the data to the api and clear the text fields
        private async Task LoadData()
        {
            txtOriginalName.Text = "";
            txtTrainingPlanName.Text = "";
            // clear the old list of training plans
            items  = new StackLayout();
            trainingPlans = await controller.getTrainingPlans();
            if (trainingPlans != null)
            {
                // iterate through the training plans with the index
                for (int i = 0; i < trainingPlans.Count; i++)
                {
                    // generate a swipe view with the training plan
                    SwipeView swipeView
                    = GenerateTrainingPlanSwipeView(trainingPlans[i], i);
                    // add the swipe view to the list
                    items.Children.Add(swipeView);
                }
            }
            else
            {
                await DisplayAlert("Error", "Could not retreive Training Plans", "OK");
            }

        }

        private SwipeView GenerateTrainingPlanSwipeView(
            TrainingPlan trainingPlan,
            int index)
        {
            SwipeItem editSwipeItem = new SwipeItem
            {
                Text = "Edit",
                BackgroundColor = Color.LightGreen,
                IconImageSource = "edit.png"
            };
            SwipeItem deleteSwipeItem = new SwipeItem
            {
                Text = "Delete",
                BackgroundColor = Color.LightPink,
                IconImageSource = "delete.png"
            };

            deleteSwipeItem.Invoked += OnDeleteSwipeItemInvoked;
            editSwipeItem.Invoked += OnEditSwipeItemInvoked;
            List<SwipeItem> swipeItems
                = new List<SwipeItem> { editSwipeItem, deleteSwipeItem };
            // content
            StackLayout layout = new StackLayout
            {
                Orientation = StackOrientation.Vertical,
                Padding = new Thickness(10, 10, 10, 10),
                BackgroundColor = Color.White,
                Children =
                {
                    // a hidden label with the id
                    new Label
                    {
                        Text = trainingPlan.id.ToString(),
                        IsEnabled = false,
                    },
                    new Label
                    {
                        Text = trainingPlan.name,
                        FontSize = Device.GetNamedSize(NamedSize.Medium, typeof(Label)),
                        FontAttributes = FontAttributes.Bold,
                        HorizontalOptions = LayoutOptions.StartAndExpand,
                        VerticalOptions = LayoutOptions.CenterAndExpand
                    },
                    // a mockup qr code
                    new Image
                    {
                        Source = "qr_sample.png",
                        HorizontalOptions = LayoutOptions.EndAndExpand,
                        VerticalOptions = LayoutOptions.CenterAndExpand
                    }
                }
            };



            SwipeView swipeView = new SwipeView
            {
                LeftItems = new SwipeItems(swipeItems),
                Content = layout,
            };

            return swipeView;
        }

    }
}