namespace EParkApi.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class space
    {
        public int ID { get; set; }
        public int CarPark { get; set; }
        public bool Stat { get; set; }
        public float x1 { get; set; }
        public float y1 { get; set; }
        public float x2 { get; set; }
        public float y2 { get; set; }
        public float x3 { get; set; }
        public float y3 { get; set; }
        public float x4 { get; set; }
        public float y4 { get; set; }
    
        public virtual carpark carpark1 { get; set; }
    }
}
