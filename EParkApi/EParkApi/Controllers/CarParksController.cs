using EParkApi.DAL;
using EParkApi.Models;
using System.Collections.Generic;
using System.Web.Http;
using System.Web.Http.Description;

namespace EParkApi.Controllers
{
    public class CarParksController : ApiController
    {
        private readonly IRepository<CarParkDTO> _repository;

        public CarParksController()
        {
            _repository = new CarParksRepository(new eparkdbEntities1());
        }

        // GET: api/carparks
        public List<CarParkDTO> Getcarparks()
        {
            return _repository.GetAllItems();
        }

        // GET: api/carparks/5
        [ResponseType(typeof(carpark))]
        public IHttpActionResult Getcarpark(int id)
        {
            var carpark = _repository.GetItemById(id);
            if (carpark == null)
            {
                return NotFound();
            }

            return Ok(carpark);
        }
    }
}