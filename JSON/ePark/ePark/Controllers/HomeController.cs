using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Web.Script.Serialization;
using ePark.Models;

namespace ePark.Controllers
{
    public class HomeController : Controller
    {
        private eParkContext db = new eParkContext();

        private List<Space> space = new List<Space>(); 

        public ActionResult Index()
        {
            return View();
        }

        [HttpPost]
        public JsonResult InsertSpace(string spaceJson)
        {
            var js = new JavaScriptSerializer();
            space.Add(js.Deserialize<Space>(spaceJson));

            //TODO: user now contains the details, you can do required operations  
            return Json("User Details are updated");
        }

        public ActionResult Contact()
        {
            ViewBag.Message = "Your contact page.";

            return View();
        }
    }
}