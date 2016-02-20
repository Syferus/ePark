using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using ePark.Models;

namespace ePark.Controllers
{
    public class SpacesController : Controller
    {
        private eParkContext db = new eParkContext();

        // GET: Spaces
        public ActionResult Index()
        {
            return View(db.Spaces.ToList());
        }

        // GET: Spaces/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Space space = db.Spaces.Find(id);
            if (space == null)
            {
                return HttpNotFound();
            }
            return View(space);
        }

        // GET: Spaces/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: Spaces/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "SpaceID,x1,x2,x3,x4,y1,y2,y3,y4")] Space space)
        {
            if (ModelState.IsValid)
            {
                db.Spaces.Add(space);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(space);
        }

        // GET: Spaces/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Space space = db.Spaces.Find(id);
            if (space == null)
            {
                return HttpNotFound();
            }
            return View(space);
        }

        // POST: Spaces/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "SpaceID,x1,x2,x3,x4,y1,y2,y3,y4")] Space space)
        {
            if (ModelState.IsValid)
            {
                db.Entry(space).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(space);
        }

        // GET: Spaces/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Space space = db.Spaces.Find(id);
            if (space == null)
            {
                return HttpNotFound();
            }
            return View(space);
        }

        // POST: Spaces/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            Space space = db.Spaces.Find(id);
            db.Spaces.Remove(space);
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
