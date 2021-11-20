package com.scirow.app;

import android.content.Context;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.View;

import com.google.android.material.bottomnavigation.BottomNavigationView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.browser.customtabs.CustomTabsIntent;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.navigation.ui.AppBarConfiguration;
import androidx.navigation.ui.NavigationUI;

import com.scirow.app.databinding.ActivityMainBinding;

public class MainActivity extends AppCompatActivity {

    private ActivityMainBinding binding;
    Context context;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        // https://api.scirow.kenzap.com/dibag.php?route=stats&token=vdfvdd8n372xfgenixugesxdnwehjsdbw

        context = this;
        SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(context);
        Integer index = pref.getInt("index",88);

        // low index
        if(index >= 0 && index < 33){
            setTheme(R.style.Theme_Scirow_1);
        }

        // medium index
        if(index >= 33 && index < 66){
            setTheme(R.style.Theme_Scirow_2);
        }

        // high index
        if(index >= 66 && index < 100){
            setTheme(R.style.Theme_Scirow_3);
        }

        super.onCreate(savedInstanceState);

        binding = ActivityMainBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        BottomNavigationView navView = findViewById(R.id.nav_view);
        // Passing each menu ID as a set of Ids because each
        // menu should be considered as top level destinations.
        AppBarConfiguration appBarConfiguration = new AppBarConfiguration.Builder(R.id.navigation_home, R.id.navigation_dashboard, R.id.navigation_notifications).build();
        NavController navController = Navigation.findNavController(this, R.id.nav_host_fragment_activity_main);
        NavigationUI.setupActionBarWithNavController(this, navController, appBarConfiguration);
        NavigationUI.setupWithNavController(binding.navView, navController);

        getSupportActionBar().setDisplayOptions(ActionBar.DISPLAY_SHOW_CUSTOM);
        getSupportActionBar().setCustomView(R.layout.custom_toolbar);
    }

    public void viewLeadership(View v){

        String url = "https://scirow.kenzap.com/leadership/";
        CustomTabsIntent.Builder builder = new CustomTabsIntent.Builder();
        CustomTabsIntent customTabsIntent = builder.build();
        customTabsIntent.launchUrl(context, Uri.parse(url));
    }
}