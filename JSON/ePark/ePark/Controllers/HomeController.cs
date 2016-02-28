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

        //private List<Space> space = new List<Space>(); 

        public ActionResult Index()
        {
            return View();
        }

        [HttpPost]
        public JsonResult InsertSpace(string spaceJson)
        {
            Space space = new Space();
            var js = new JavaScriptSerializer();
            space = (js.Deserialize<Space>(spaceJson));

            db.Spaces.Add(space);
            db.SaveChanges();
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