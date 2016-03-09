namespace EParkApi.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class carpark
    {
        public int ID { get; set; }
        public string Name { get; set; }
        public string GPS { get; set; }
        public int Location { get; set; }
        public string Resolution { get; set; }
        public short Frequency { get; set; }
        public string ImageName { get; set; }
        public int FreeSpaces { get; set; }
        public string Address { get; set; }
    }
}
