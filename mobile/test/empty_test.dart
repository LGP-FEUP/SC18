
import 'package:flutter_test/flutter_test.dart';

import 'package:erasmus_helper/main.dart';

void main() {
  testWidgets('Does nothing test', (WidgetTester tester) async {
    await tester.pumpWidget(const MyApp());
  });
}