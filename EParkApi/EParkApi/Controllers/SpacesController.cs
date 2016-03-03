using EParkApi.DAL;
using EParkApi.Models;
using System.Collections.Generic;
using System.Linq;
using System.Web.Http;
using System.Web.Http.Description;

namespace EParkApi.Controllers
{
    public class SpacesController : ApiController
    {
        private readonly IRepository<space> _repository;

        public SpacesController()
        {
            _repository = new SpacesRepository(new eparkdbEntities1());
        }

        // GET: api/spaces
        public List<space> Getspaces()
        {
            return _repository.GetAllItems().ToList();
        }

        // GET: api/spaces/5
        [ResponseType(typeof(space))]
        public IHttpActionResult Getspace(int id)
        {
            var space = _repository.GetItemById(id);
            if (space == null)
            {
                return NotFound();
            }

            return Ok(space);
        }
    }
}