using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;

namespace ePark.Models
{
    public class CarPark
    {
        [Key]
        public int CarParkID { get; set; }

        public int LocationID { get; set; }

        public virtual List<Space> Spaces { get; set; }
    }

    public class Space
    {
        [Key]
        public int SpaceID { get; set; }

        public virtual CarPark CarPark { get; set; }
        public double x1 { get; set; }
        public double x2 { get; set; }
        public double x3 { get; set; }
        public double x4 { get; set; }
        public double y1 { get; set; }
        public double y2 { get; set; }
        public double y3 { get; set; }
        public double y4 { get; set; }
    }
}