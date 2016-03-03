using EParkApi.DAL;
using EParkApi.Models;
using System.Collections.Generic;
using System.Web.Http;
using System.Web.Http.Description;

namespace EParkApi.Controllers
{
    public class LocationsController : ApiController
    {
        private readonly IRepository<location> _repository;

        public LocationsController()
        {
            _repository = new LocationsRepository(new eparkdbEntities1());
        }

        // GET: api/locations
        public List<location> Getlocations()
        {
            return _repository.GetAllItems();
        }

        // GET: api/locations/5
        [ResponseType(typeof(location))]
        public IHttpActionResult Getlocation(int id)
        {
            var location = _repository.GetItemById(id);
            if (location == null)
            {
                return NotFound();
            }

            return Ok(location);
        }
    }
}