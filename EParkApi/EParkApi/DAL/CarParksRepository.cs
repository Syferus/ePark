using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;

namespace EParkApi.DAL
{
    public class CarParksRepository : IRepository<CarParkDTO>
    {
        private readonly eparkdbEntities1 _context;

        private readonly List<CarParkDTO> _itemsDetails = new List<CarParkDTO>();

        public CarParksRepository(eparkdbEntities1 context)
        {
            _context = context;

            var items = _context.carparks.ToList();

            foreach (var i in items)
            {
                _itemsDetails.Add(new CarParkDTO()
                {
                    Id = i.ID,
                    Name = i.Name,
                    Gps = i.GPS,
                    Location = i.Location,
                    TotalSpaces = i.spaces.Count(),
                    FreeSpaces = i.spaces.Count(s => s.Stat == false)
                });
            }
        }

        public void Dispose()
        {
            _context.Dispose();
        }

        public List<CarParkDTO> GetAllItems()
        {
            return _itemsDetails;
        }

        public CarParkDTO GetItemById(int id)
        {
            return _itemsDetails.Find(s => s.Id == id);
        }
    }
}