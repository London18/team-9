package com.ratga.mymix.models;

import java.util.Date;

public class Session {
    private Integer sessionId;
    private Date creationTime;

    public Integer getSessionId() {
        return this.sessionId;
    }

    public void setSessionId(Integer sessionId) {
        this.sessionId = sessionId;
    }

    public Date getCreationTime() {
        return this.creationTime;
    }

    public void setCreationTime(Date creationTime) {
        this.creationTime = creationTime;
    }

    public Session() {
    }
}
