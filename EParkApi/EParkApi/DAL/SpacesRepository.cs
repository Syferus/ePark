using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;

namespace EParkApi.DAL
{
    public class SpacesRepository : IRepository<space>
    {
        private readonly eparkdbEntities1 _context;

        public SpacesRepository(eparkdbEntities1 context)
        {
            _context = context;
        }

        public void Dispose()
        {
            _context.Dispose();
        }

        public List<space> GetAllItems()
        {
            return _context.spaces.ToList();
        }

        public space GetItemById(int id)
        {
            return _context.spaces.Find(id);
        }
    }
}