﻿using System;
using System.Collections.Generic;
using System.Text;

using Newtonsoft.Json;

namespace Examen2.model
{
    public class TrainingPlan
    {
        // id is optional
        [JsonProperty(NullValueHandling=NullValueHandling.Ignore)]
        public int? id { get; set; }
        public string name { get; set; }
        public string username { get; set; }
        // the list of activities is nullable
        public List<Activity> activities { get; set; } = new List<Activity>();

        public TrainingPlan()
        {
            name = "";
            username = "";
        }

        public TrainingPlan(string name, string username)
        {
            this.name = name;
            this.username = username;
        }
    }
}
