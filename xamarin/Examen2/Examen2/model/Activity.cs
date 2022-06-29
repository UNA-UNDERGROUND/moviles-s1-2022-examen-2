using System;
using System.Collections.Generic;
using System.Text;

namespace Examen2.model
{
    public class Activity
    {
        // id is nullable
        public int? id { get; set; }
        // idTrainingPlan is nullable
        public int? idTrainingPlan { get; set; }
        public Day day { get; set; }
        public string name { get; set; }
        public int repetitions { get; set; }
        public int breaks { get; set; }
        public int series { get; set; }
        public int cadence { get; set; }
        public int weight { get; set; }


        public class Day
        {

            // day list
            public static readonly Day Monday = new Day("Monday", "M");
            public static readonly Day Tuesday = new Day("Tuesday", "T");
            public static readonly Day Wednesday = new Day("Wednesday", "W");
            public static readonly Day Thursday = new Day("Thursday", "R");
            public static readonly Day Friday = new Day("Friday", "F");
            public static readonly Day Saturday = new Day("Saturday", "S");
            public static readonly Day Sunday = new Day("Sunday", "U");


            public static IEnumerable<Day> Values
            {
                get
                {
                    yield return Monday;
                    yield return Tuesday;
                    yield return Wednesday;
                    yield return Thursday;
                    yield return Friday;
                    yield return Saturday;
                    yield return Sunday;
                }
            }

            public string name { get; set; }
            public string code { get; set; }

            public Day(string name, string code)
            {
                this.name = name;
                this.code = code;
            }

            public Day getByCode(string code)
            {
                foreach (Day day in Values)
                {
                    if (day.code == code)
                    {
                        return day;
                    }
                }
                return null;
            }
            public Day getByName(string name)
            {
                foreach (Day day in Values)
                {
                    if (day.name == name)
                    {
                        return day;
                    }
                }
                return null;
            }


        }
    }
}
