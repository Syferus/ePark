using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;

namespace EParkApi.DAL
{
    public class LocationsRepository : IRepository<location>
    {
        private readonly eparkdbEntities1 _context;

        public LocationsRepository(eparkdbEntities1 context)
        {
            _context = context;
        }

        public void Dispose()
        {
            _context.Dispose();
        }

        public List<location> GetAllItems()
        {
            return _context.locations.ToList();
        }

        public location GetItemById(int id)
        {
            return _context.locations.Find(id);
        }
    }
}