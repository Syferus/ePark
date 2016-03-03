using System;
using System.Collections.Generic;

namespace EParkApi.DAL
{
    public interface IRepository<T> : IDisposable
    {
        List<T> GetAllItems();

        T GetItemById(int id);
    }
}