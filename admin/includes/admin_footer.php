            </div>
        </div>
    </div>
    
    <script>
    // Simple utility: confirm delete
    function confirmDelete(formId, message = 'Delete this item permanently?') {
        if (confirm(message)) {
            document.getElementById(formId).submit();
        }
    }
    </script>
</body>
</html>