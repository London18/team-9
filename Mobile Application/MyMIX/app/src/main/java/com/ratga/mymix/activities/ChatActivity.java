package com.ratga.mymix.activities;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.EditText;
import android.widget.TextView;

import com.ratga.mymix.R;
import com.stfalcon.chatkit.messages.MessageInput;
import com.stfalcon.chatkit.messages.MessagesList;

public class ChatActivity extends AppCompatActivity {

    private MessagesList messagesList;
    private EditText inputView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat);
        messagesList = findViewById(R.id.messagesList);
        inputView = findViewById(R.id.input);
    }
}
