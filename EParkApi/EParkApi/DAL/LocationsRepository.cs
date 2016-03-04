using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;

namespace EParkApi.DAL
{
    public class LocationsRepository : IRepository<LocationsDTO>
    {
        private readonly eparkdbEntities1 _context;

        private readonly List<LocationsDTO> _itemsDetails = new List<LocationsDTO>();

        public LocationsRepository(eparkdbEntities1 context)
        {
            _context = context;

            var items = _context.locations.ToList();

            foreach (var i in items)
            {
                _itemsDetails.Add(new LocationsDTO()
                {
                    Id = i.ID,
                    County = i.County
                });
            }
        }

        public void Dispose()
        {
            _context.Dispose();
        }

        public List<LocationsDTO> GetAllItems()
        {
            return _itemsDetails;
        }

        public LocationsDTO GetItemById(int id)
        {
            return _itemsDetails.Find(s => s.Id == id);
        }
    }
}