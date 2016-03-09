namespace EParkApi.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class carpark
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public carpark()
        {
            this.spaces = new HashSet<space>();
        }
    
        public int ID { get; set; }
        public string Name { get; set; }
        public string GPS { get; set; }
        public int Location { get; set; }
        public string Resolution { get; set; }
        public short Frequency { get; set; }
        public string ImageName { get; set; }
        public int FreeSpaces { get; set; }

        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<space> spaces { get; set; }
        public virtual location location1 { get; set; }
    }
}
