using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;

namespace EParkApi.DAL
{
    public class CarParksRepository : IRepository<carpark>
    {
        private readonly eparkdbEntities1 _context;

        public CarParksRepository(eparkdbEntities1 context)
        {
            _context = context;
        }

        public void Dispose()
        {
            _context.Dispose();
        }

        public List<carpark> GetAllItems()
        {
            return _context.carparks.ToList();
        }

        public carpark GetItemById(int id)
        {
            return _context.carparks.Find(id);
        }
    }
}