CREATE OR REPLACE PROCEDURE SP_DELETE_SERVER
(
P_CONSUMER_KEY      IN        VARCHAR2,
P_USER_ID           IN        NUMBER,
P_USER_IS_ADMIN     IN        NUMBER, --0:NO; 1:YES
P_RESULT            OUT       NUMBER
)
AS
 
 --  Delete a server key.  This removes access to that site.

BEGIN
P_RESULT := 0;

IF P_USER_IS_ADMIN = 1 THEN

  DELETE FROM OAUTH_CONSUMER_REGISTRY
  WHERE OCR_CONSUMER_KEY = P_CONSUMER_KEY
  AND (OCR_USA_ID_REF = P_USER_ID OR OCR_USA_ID_REF IS NULL);
  
ELSIF P_USER_IS_ADMIN = 0 THEN

  DELETE FROM OAUTH_CONSUMER_REGISTRY
  WHERE OCR_CONSUMER_KEY = P_CONSUMER_KEY
  AND OCR_USA_ID_REF   = P_USER_ID;
  
END IF;
     
EXCEPTION
WHEN OTHERS THEN
-- CALL THE FUNCTION TO LOG ERRORS
ROLLBACK;
P_RESULT := 1; -- ERROR
END;
/