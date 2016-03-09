namespace EParkApi.Models
{
    public class CarParkDTO
    {
        public int Id { get; set; }
        public string Name { get; set; }
        public string Gps { get; set; }
        public int Location { get; set; }
        public int FreeSpaces { get; set; }
        public string Address { get; set; }
    }
}