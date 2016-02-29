using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using MySql3;

namespace MySql3.Controllers
{
    public class carparkdetailsController : Controller
    {
        private eparkmysqldbEntities db = new eparkmysqldbEntities();

        // GET: carparkdetails
        public ActionResult Index()
        {
            return View(db.carparkdetails.ToList());
        }

        // GET: carparkdetails/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carparkdetail carparkdetail = db.carparkdetails.Find(id);
            if (carparkdetail == null)
            {
                return HttpNotFound();
            }
            return View(carparkdetail);
        }

        // GET: carparkdetails/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: carparkdetails/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "CarParkID,CarParkName,CarParkAddress,Resolution,Frequency,ImageName")] carparkdetail carparkdetail)
        {
            if (ModelState.IsValid)
            {
                db.carparkdetails.Add(carparkdetail);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(carparkdetail);
        }

        // GET: carparkdetails/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carparkdetail carparkdetail = db.carparkdetails.Find(id);
            if (carparkdetail == null)
            {
                return HttpNotFound();
            }
            return View(carparkdetail);
        }

        // POST: carparkdetails/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "CarParkID,CarParkName,CarParkAddress,Resolution,Frequency,ImageName")] carparkdetail carparkdetail)
        {
            if (ModelState.IsValid)
            {
                db.Entry(carparkdetail).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(carparkdetail);
        }

        // GET: carparkdetails/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            carparkdetail carparkdetail = db.carparkdetails.Find(id);
            if (carparkdetail == null)
            {
                return HttpNotFound();
            }
            return View(carparkdetail);
        }

        // POST: carparkdetails/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            carparkdetail carparkdetail = db.carparkdetails.Find(id);
            db.carparkdetails.Remove(carparkdetail);
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
