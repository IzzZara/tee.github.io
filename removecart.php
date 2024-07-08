<?php
include 'dbconnect.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cloNum'])) {
    $cloNum = $data['cloNum'];
    $username = $_SESSION['id'];

    if (!isset($username)) {
        echo json_encode( 'User not logged in.');
        exit();
    }

    // Start transaction
    $connect->begin_transaction();

    try {
        // Remove item from cart
        $stmt = $connect->prepare('DELETE FROM cart WHERE CLO_NUM = ? AND CUS_ID = ?');
        $stmt->bind_param('ii', $cloNum, $username);
        if (!$stmt->execute()) {
            throw new Exception('Failed to remove item from cart.');
        }
        $stmt->close();

        // Commit transaction
        $connect->commit();
        echo json_encode( 'Item removed from cart successfully!');
    } catch (Exception $e) {
        // Rollback transaction on error
        $connect->rollback();
        echo json_encode(['message' => $e->getMessage()]);
    }

    $connect->close();
} else {
    echo json_encode('Invalid input.');
}
?>
