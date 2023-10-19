import 'dart:async';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';

enum UnispendTheme { light, dark, moonlight, royal }

class UnispendWidget extends StatefulWidget {
  /// Invoked when a javascript message is returned from the UnispendChannel.
  final void Function(String)? onMessageReceived;

  /// Max amount users can spend in USD.
  final double maxAmountInUSD;

  /// Primary colour used. Defaults to Purple.
  final Color primaryColor;

  /// The widget's theme. Defaults to light mode.
  final UnispendTheme UnispendTheme;

  /// DebugPrint events as they occur. Defaults to true.
  final bool logEvent;

  /// Creates a new Unispend widget.
  ///
  /// The widget has an [onMessageReceived] callback that listens to the UnispendChannel
  ///
  /// The UnispendWidget can be customised to user's preference.
  const UnispendWidget(
      {Key? key,
      this.onMessageReceived,
      this.UnispendTheme = UnispendTheme.light,
      required this.maxAmountInUSD,
      this.primaryColor = Colors.purple,
      this.logEvent = true})
      : super(key: key);

  @override
  State<UnispendWidget> createState() => _UnispendWidgetState();
}

class _UnispendWidgetState extends State<UnispendWidget> {
  final Completer<WebViewController> _controller =
      Completer<WebViewController>();
  final String UnispendHost = 'https://Unispend.com';

  @override
  void initState() {
    super.initState();
    if (Platform.isAndroid) {
      WebView.platform = SurfaceAndroidWebView();
    }
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
          body: WebView(
        initialUrl: UnispendHost +
            '/?cSContext=mobile' +
            '&primaryColor=${widget.primaryColor.value.toRadixString(16).substring(2)}' +
            '&xAppStyle=${widget.UnispendTheme.name}' +
            '&maxAmountInUSD=${widget.maxAmountInUSD}',
        javascriptMode: JavascriptMode.unrestricted,
        onWebViewCreated: (WebViewController webViewController) {
          _controller.complete(webViewController);
        },
        onProgress: (int progress) {
          debugPrint('Unispend is loading (progress : $progress%)');
        },
        javascriptChannels: {
          JavascriptChannel(
            name: 'UnispendChannel',
            onMessageReceived: (message) async {
              if (widget.logEvent) {
                debugPrint('Javascript: ${message.message}');
              }
              if (widget.onMessageReceived != null) {
                widget.onMessageReceived!(message.message);
              }
            },
          ),
        },
        onPageStarted: (String url) {
          if (widget.logEvent) {
            debugPrint('Page started loading: $url');
          }
        },
        onPageFinished: (String url) {
          if (widget.logEvent) {
            debugPrint('Page finished loading: $url');
          }
        },
        gestureNavigationEnabled: true,
        backgroundColor: const Color(0x00000000),
      )),
    );
  }
}
