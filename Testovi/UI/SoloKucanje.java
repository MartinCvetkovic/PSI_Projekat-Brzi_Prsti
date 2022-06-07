package testovi;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.testng.Assert;
import org.testng.annotations.AfterClass;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeClass;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;



import org.openqa.selenium.Keys;
public class SoloKucanje {
    
    public static String baseURL = "http://localhost:8000/solo/13";
    public static WebDriver driver;

    
    @Test
    public void soloKucanjeGost() {
        try {
            driver.get(baseURL);
            driver.manage().window().maximize();

	    driver.findElement(By.id("userInput")).sendKeys("A");
	    driver.findElement(By.id("userInput")).sendKeys(Keys.BACK_SPACE);
	    String mistakes = driver.findElement(By.id("mistakes")).getText();
            Assert.assertTrue(mistakes.contains("1"));

            String text = "Početak je najvažniji deo svakog posla. - Platon";
	    for(Character c: text.toCharArray()){
		driver.findElement(By.id("userInput")).sendKeys("" + c);
	    }
	    
	    Thread.sleep(5000);
	    
	    String welcomeMsg = driver.findElement(By.cssSelector("td:nth-child(1) > p:nth-child(1)")).getText();
            Assert.assertTrue(welcomeMsg.contains("brzina kucanja"));
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }
    
    @BeforeClass
    public static void setUpClass() throws Exception {
    }

    @AfterClass
    public static void tearDownClass() throws Exception {
    }

    @BeforeMethod
    public void setUpMethod() throws Exception {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\PC\\Downloads\\chromedriver.exe");
        driver = new ChromeDriver();
    }

    @AfterMethod
    public void tearDownMethod() throws Exception {
        if(driver != null)
            driver.quit();
    }
}