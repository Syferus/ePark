using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace Compare_Images
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        private void MainWindow_OnLoaded(object sender, RoutedEventArgs e)
        {
            BitmapImage bi = new BitmapImage();
            // BitmapImage.UriSource must be in a BeginInit/EndInit block.
            bi.BeginInit();
            bi.UriSource = new Uri(@"..\..\EmptyCarPark.jpg", UriKind.RelativeOrAbsolute);
            bi.EndInit();

            BitmapImage bi2 = new BitmapImage();
            // BitmapImage.UriSource must be in a BeginInit/EndInit block.
            bi2.BeginInit();
            bi2.UriSource = new Uri(@"..\..\FullCarPark.jpg", UriKind.RelativeOrAbsolute);
            bi2.EndInit();
            // Set the image source.
            tblResult.Content = (bi.IsEqual(bi2)) ? "Same Image" : "Different images";

            img1.Source = bi;
            img2.Source = bi2;
        }
    }
}
