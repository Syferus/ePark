using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using EparkApp1;

namespace EparkApp1.Controllers
{
    public class carparksController : Controller
    {
        private eparkdbEntities db = new eparkdbEntities();

        // GET: carparks
        public ActionResult Index()
        {
            var carparks = db.carparks.Include(c => c.location1);
            return View(carparks.ToList());
        }

        // GET: carparks/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carpark carpark = db.carparks.Find(id);
            if (carpark == null)
            {
                return HttpNotFound();
            }
            return View(carpark);
        }

        // GET: carparks/Create
        public ActionResult Create()
        {
            ViewBag.Location = new SelectList(db.locations, "ID", "County");
            return View();
        }

        // POST: carparks/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "ID,Name,GPS,Location")] carpark carpark)
        {
            if (ModelState.IsValid)
            {
                db.carparks.Add(carpark);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            ViewBag.Location = new SelectList(db.locations, "ID", "County", carpark.Location);
            return View(carpark);
        }

        // GET: carparks/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carpark carpark = db.carparks.Find(id);
            if (carpark == null)
            {
                return HttpNotFound();
            }
            ViewBag.Location = new SelectList(db.locations, "ID", "County", carpark.Location);
            return View(carpark);
        }

        // POST: carparks/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "ID,Name,GPS,Location")] carpark carpark)
        {
            if (ModelState.IsValid)
            {
                db.Entry(carpark).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            ViewBag.Location = new SelectList(db.locations, "ID", "County", carpark.Location);
            return View(carpark);
        }

        // GET: carparks/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carpark carpark = db.carparks.Find(id);
            if (carpark == null)
            {
                return HttpNotFound();
            }
            return View(carpark);
        }

        // POST: carparks/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            carpark carpark = db.carparks.Find(id);
            db.carparks.Remove(carpark);
            db.SaveChanges();
            return RedirectToAction("Index");
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}
