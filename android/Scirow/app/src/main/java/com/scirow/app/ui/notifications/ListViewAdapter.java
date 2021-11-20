package com.scirow.app.ui.notifications;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.scirow.app.R;

public class ListViewAdapter extends BaseAdapter {

    Context context;
    LayoutInflater inflter;
    String icon[] = {"⚠️", "\uD83D\uDCE2", "\uD83D\uDD17", "⚠️",
            "\uD83D\uDCA7", "\uD83D\uDE15", "\uD83E\uDD5B", "\uD83E\uDD5B", "\uD83E\uDD5B"};
    String text[];
    String action[] = {"yes/no", "config", "view", "view",
            "Bathroom faucet 2", "Shower faucet", "Basin electra", "Kitchen faucet 2", "Kitchen faucet 3"};

    public ListViewAdapter(Context applicationContext, String[] text) {
        this.context = applicationContext;
        this.text = text;
        inflter = (LayoutInflater.from(applicationContext));
    }
    @Override
    public int getCount() {
        return text.length;
    }
    @Override
    public Object getItem(int i) {
        return null;
    }
    @Override
    public long getItemId(int i) {
        return 0;
    }
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        view = inflter.inflate(R.layout.adapter_notifications, null); // inflate the layout
        TextView action = (TextView) view.findViewById(R.id.action); // get the reference of ImageView
        TextView text = (TextView) view.findViewById(R.id.text);
        TextView icon = (TextView) view.findViewById(R.id.icon);
        icon.setText(this.icon[i]);
        text.setText(this.text[i]);

        return view;
    }
}