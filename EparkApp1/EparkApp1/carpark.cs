//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace EparkApp1
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
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<space> spaces { get; set; }
        public virtual location location1 { get; set; }
    }
}
