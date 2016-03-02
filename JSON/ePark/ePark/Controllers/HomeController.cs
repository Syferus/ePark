using System;
using System.Collections.Generic;
using System.Data.Entity;
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
            
            return Json("Space was inserted");
        }

        [HttpPost]
        public JsonResult UpdateFull(string spaceJson)
        {
            var js = new JavaScriptSerializer();

            List<Space> spaces = js.Deserialize<List<Space>>(spaceJson);

            foreach (Space sp in spaces)
            {
                db.Entry(sp).State = EntityState.Modified;
            }
            db.SaveChanges();
            return Json("User Details are updated");
        }
        public ActionResult About()
        {
           return View();
        }


        //[HttpGet]
        public ActionResult GetSpace()
        {
            List<Space> sp = db.Spaces.ToList(); 
    
            //JavaScriptSerializer js = new JavaScriptSerializer();
            return Json(new { space = sp}, JsonRequestBehavior.AllowGet);
        }
    }
}